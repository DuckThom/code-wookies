set nocompatible                           " Disable vi-compatibility
set t_Co=256

colorscheme xoria256
set go-=L                                  " Removes left hand scroll bar
set linespace=15

set shortmess+=I                           " Disable welcome message
set showmode                               " Always show what mode we're currently editing in
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
set mouse=a
set tabstop=4
set shiftwidth=4
set softtabstop=4
set smarttab
set expandtab
set autoindent
set smartindent

syntax on

" Split window navigation
map <silent> j :tabprevious<cr>
map <silent> k :tabnext<cr>

" NERDTree config
" Bind Ctrl-n to NERDTree toggle
map <Leader>n <plug>NERDTreeTabsToggle<CR>

" Hide NERDTree help text 
let g:NERDTreeMinimalUI = 1
" Auto open NERDTree 
let g:nerdtree_tabs_open_on_console_startup = 1
" Always focus on the file tab by default
let g:nerdtree_tabs_smart_startup_focus = 2
