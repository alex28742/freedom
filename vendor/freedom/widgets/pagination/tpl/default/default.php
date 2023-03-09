<?php

    $back = null; // ссылка НАЗАД
    $forward = null; // ссылка ВПЕРЕД
    $startpage = null; // ссылка в НАЧАЛО
    $endpage = null; // ссылка в КОНЕЦ
    $page2left = null; // вторая страница слева
    $page1left = null; // первая страница слева
    $page2right = null; // вторая страница справа
    $page1right = null; // первая страница справа

    // формируем страницу НАЗАД
    if($this->currentPage > 1){
        $back = "<li class='page-item'><a class='page-link page-back' href='{$this->uri}page=".($this->currentPage - 1)."'>&lt;</a></li>";
    }
    // формируем ссылку ВПЕРЕД
    if($this->currentPage < $this->totalPages){
        $forward = "<li class='page-item'><a class='page-link page-forward' href='{$this->uri}page=".($this->currentPage + 1)."'>&gt;</a></li>";
    }
    // формируем ссылку на первую страницу
    if($this->currentPage > 3){
        $startpage = "<li class='page-item'><a class='page-link page-start' href='{$this->uri}page=1'>&laquo;</a></li>";
    }
    // формируем ссылку на последнюю страницу
    if($this->currentPage < ($this->totalPages - 2)){
        $endpage = "<li class='page-item'><a class='page-link page-end' href='{$this->uri}page=".$this->totalPages."'>&raquo;</a></li>";
    }
    // формируем ссылку на две страницы назад
    if($this->currentPage - 2 > 0){
        $page2left = "<li class='page-item'><a class='page-link page-2left' href='{$this->uri}page=".($this->currentPage - 2)."'>".($this->currentPage - 2)."</a></li>";
    }
    // формируем ссылку на одну страницу назад
    if($this->currentPage - 1 > 0){
        $page1left = "<li class='page-item'><a class='page-link page-1left' href='{$this->uri}page=".($this->currentPage - 1)."'>".($this->currentPage - 1)."</a></li>";
    }
    // формируем ссылку на две страницы вперед
    if($this->currentPage + 2 <= $this->totalPages){
        $page2right = "<li class='page-item'><a class='page-link page-2right' href='{$this->uri}page=".($this->currentPage + 2)."'>".($this->currentPage + 2)."</a></li>";
    }
    // формируем ссылку на одну страницу вперед
    if($this->currentPage + 1 <= $this->totalPages){
        $page1right = "<li class='page-item'><a class='page-link page-1right' href='{$this->uri}page=".($this->currentPage + 1)."'>".($this->currentPage + 1)."</a></li>";
    }

    echo '<ul class="pagination justify-content-center">' . $startpage.$back.$page2left.$page1left . '<li class="page-item active"><a class="page-link">'.$this->currentPage.'</a></li>'.$page1right.$page2right.$forward.$endpage . '</ul>';
