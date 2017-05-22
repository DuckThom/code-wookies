#!/bin/bash

# Store menu options selected by the user
INPUT=/tmp/menu.sh.$$

# Storage file for displaying cal and date command output
OUTPUT=/tmp/output.sh.$$

# trap and delete temp files
trap "rm $OUTPUT; rm $INPUT; exit" SIGHUP SIGINT SIGTERM

code=0

### display main menu ###
function show_menu() {
    dialog --clear --backtitle "Calypso" \
    --title "[ M A I N - M E N U ]" \
    --cancel-label "Disconnect" \
    --menu "Select an action from the list below" 20 75 5 \
    Shell "Drop to a shell ($SHELL)" \
    Editor "Start a text editor" \
    Htop "Open htop" \
    IRC "Attach to screen 'weechat'" \
    Exit "Disconnect from $(hostname)" 2>"${INPUT}"

    code=$?
}

function weechat_choose_action() {
    local menuitem

    dialog --clear \
        --title "Could not attach to the screen" \
        --cancel-label "Close" \
        --menu "Please select an option" 20 75 5 \
        Retry "Retry" \
        Detach "Try to detach an existing connection" \
        Force "Try to attach without detaching the current connection" \
        Close "Return to the main menu" 2>"${INPUT}"

    menuitem=$(<"${INPUT}")

    case $menuitem in
        Retry) normal_attach_weechat;;
        Detach) detach_attach_weechat;;
        Force) force_attach_weechat;;
    esac
}

function start_shell() {
    echo ""
    echo "To return to the menu, exit this shell."
    echo ""
    $SHELL
}

function disconnect() {
    exit
}

function normal_attach_weechat() {
    screen -r weechat

    if [ "$?" != "0" ]; then
        weechat_choose_action
    fi
}

function detach_attach_weechat() {
    screen -dr weechat

    if [ "$?" != "0" ]; then
        weechat_choose_action
    fi
}

function force_attach_weechat() {
    screen -xr weechat

    if [ "$?" != "0" ]; then
        weechat_choose_action
    fi
}

while true; do
    show_menu

    clear

    menuitem=$(<"${INPUT}")

    # make decsion 
    case $menuitem in
        Editor) vim;;
        Shell) start_shell;;
        Htop) htop;;
        IRC) normal_attach_weechat;;
        Exit) disconnect;;
    esac

    # Close the dialog when "Close" was pressed
    if [ "$code" == "1" ]; then
        disconnect
    fi

    # Drop to a shell if the dialog was closed with ESC
    if [ "$code" == "255" ]; then
        echo "Dropping to shell"
        $SHELL
        break
    fi
done
