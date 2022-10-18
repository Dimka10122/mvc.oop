define(['assets/js/scripts/lib/knockout'], function (ko) {
    return function (items) {
        let viewModel = {
            allItems: ko.observableArray(items),
            pagesCountArray: ko.observableArray([]),
            currentPage: ko.observable(0),
            itemsPerPage: ko.observable(4),
            startIndex: ko.observable(0),
            currentItems: ko.observableArray([]),
            nextPage: function () {
                if (viewModel.currentPage() >= viewModel.pagesCountArray().length) {
                    viewModel.currentPage(viewModel.pagesCountArray().length);
                    return;
                }
                viewModel.currentPage(viewModel.currentPage() + 1);
            },
            // getAction: function (action) {
            //     switch (action) {
            //         case 'Select All' || 'Unselect All':
            //             viewModel.allItems().forEach(item => {
            //                 return true;
            //             })
            //             break;
            //         case 'Select This Page' || 'Unselect This Page':
            //             viewModel.currentItems().forEach(item => {
            //                 return false;
            //             })
            //             break;
            //         default:
            //             break;
            //     }
            // },
            prevPage: function () {
                if (viewModel.currentPage() <= 1) {
                    viewModel.currentPage(1);
                    return;
                }
                viewModel.currentPage(viewModel.currentPage() - 1);
            },
            switchPage: function (value) {
                viewModel.currentPage(value);
            },
            showPrevLink: ko.observable(true),
            showNextLink:  ko.observable(true),
            isVisibleItem: function (value) {
                return viewModel.currentItems().includes(value);
            },
        }


        viewModel.currentPage.subscribe(function () {
            changeStartIndex.bind(viewModel)();
            currentPageItems.bind(viewModel)();
            showLinks.bind(viewModel)()
        });

        changePagesCount.bind(viewModel)();

        function currentPageItems() {
            this.currentItems(this.allItems().slice(this.startIndex(), this.startIndex() + this.itemsPerPage()));
        }

        function changeStartIndex() {
            this.startIndex(this.currentPage() * this.itemsPerPage() - this.itemsPerPage());
        }

        function changePagesCount() {
            let pagesCount = Math.ceil(this.allItems().length / this.itemsPerPage());
            let resultArray = [];
            for (let i = 1; i <= pagesCount; i++) {
                resultArray.push(i);
            }
            this.pagesCountArray(resultArray);
        }

        function showLinks() {
            let currentPage = this.currentPage();
            if (currentPage === 1) {
                this.showPrevLink(false);
            } else {
                this.showPrevLink(true)
            }
            if (currentPage === this.pagesCountArray().length) {
                this.showNextLink(false);
            } else {
                this.showNextLink(true)
            }
        }

        return viewModel;
    }
});