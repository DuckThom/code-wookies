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

syntax on

" Split window navigation
map <silent> <A-Up> :wincmd k<cr>
map <silent> <A-Down> :wincmd j<cr>
map <silent> <A-Left> :wincmd h<cr>
map <silent> <A-Right> :wincmd l<cr>

" NERDTree config
map <silent> <C-n> :NERDTreeToggle<cr>     " Open NERDTree with Ctrl+n

let g:NERDTreeShowHidden = 1               " Show hidden files in NERDTree

autocmd VimEnter * NERDTreeToggle          " Open NERDTree by default
autocmd VimEnter * wincmd p                " Don't autofocus on NERDTree

" Close vim even if NERDTree is open
autocmd bufenter * if (winnr("$") == 1 && exists("b:NERDTreeType") && b:NERDTreeType == "primary") | q | endif
