" Enable Powerline
python from powerline.vim import setup as powerline_setup
python powerline_setup()
python del powerline_setup

set nocompatible                           " Disable vi-compatibility
set t_Co=256                               " 256 Colors
set t_ut=                                  " Fix missing background in tmux vim session

colorscheme xoria256
set go-=L                                  " Removes left hand scroll bar
set linespace=15

set encoding=utf-8                         " Force UTF-8 encoding
set laststatus=2                           " Display Powerline status bar
set shortmess+=I                           " Disable welcome message
set noshowmode                             " Never show what mode we're currently editing in
set nowrap                                 " Don't wrap lines
set tags=tags
set shiftround                             " Use multiple of shiftwidth when indenting with '<' and '>'
set backspace=indent,eol,start             " Allow backspacing over everything in insert mode
set number                                 " Always show line numbers
set ignorecase                             " Ignore case when searching
set smartcase                              " Ignore case if search pattern is all lowercase,
set timeout timeoutlen=200 ttimeoutlen=100
set visualbell                             " Don't beep
set noerrorbells                           " Don't beep
set autowrite                              " Save on buffer switch
set mouse=a                                " Enable mouse support

" Indenting
set tabstop=4
set shiftwidth=4
set softtabstop=4
set smarttab
set expandtab
set autoindent
set smartindent

" Enable automatic plugin loading from ~/.vim/bundle
execute pathogen#infect()

" Enable syntax highlighting
syntax on

" Split window navigation
map <silent> j :tabprevious<cr>
map <silent> k :tabnext<cr>

" NERDTree config

" Toggle NERDTree itself with "N" 
map <silent> N :NERDTreeToggle<cr>
" Toggle NERDTree focus with "n"
map <silent> n :NERDTreeFocusToggle<cr>

" Hide NERDTree help text 
let g:NERDTreeMinimalUI = 1
" Auto open NERDTree 
let g:nerdtree_tabs_open_on_console_startup = 1
" Always focus on the file tab by default
let g:nerdtree_tabs_smart_startup_focus = 2

" Make the Powerline very fancy
let g:Powerline_symbols = 'fancy'

