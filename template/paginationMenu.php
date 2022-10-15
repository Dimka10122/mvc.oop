<div class="navigation-block">
    <div class="form-paginator">
        <a class="nav-btn-link"
           data-bind="visible: paginationViewModel.showPrevLink, click: paginationViewModel.prevPage()">
            <
        </a>
        <ul class="pagination-pages-list" data-bind="foreach: paginationViewModel.pagesCountArray">
            <li class="btn btn-primary nav-btn"
                data-bind="text: $data, click: $parent.paginationViewModel.switchPage, css: {'active-nav-btn': $data == $parent.paginationViewModel.currentPage()}">
            </li>
        </ul>
        <a class="nav-btn-link"
           data-bind="visible: paginationViewModel.showNextLink, click: paginationViewModel.nextPage">
            >
        </a>
    </div>
</div>