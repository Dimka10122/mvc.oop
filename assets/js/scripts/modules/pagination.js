define(['assets/js/scripts/lib/knockout'], function (ko) {
    return function (items) {
        let viewModel = {
            allMessages: ko.observableArray(items),
            pagesCountArray: ko.observableArray([]),
            currentPage: ko.observable(0),
            messagesPerPage: ko.observable(4),
            startIndex: ko.observable(0),
            currentMessages: ko.observableArray([]),
            nextPage: function () {
                if (this.currentPage() >= this.pagesCountArray().length) {
                    this.currentPage(this.pagesCountArray().length);
                    return;
                }
                this.currentPage(this.currentPage() + 1);
            },
            prevPage: function () {
                if (this.currentPage() <= 1) {
                    this.currentPage(1);
                    return;
                }
                this.currentPage(this.currentPage() - 1);
            },
            switchPage: function (event) {
                this.currentPage(event);
            },
            showPrevLink: ko.observable(true),
            showNextLink:  ko.observable(true)
        }

        viewModel.currentPage.subscribe(function (messages) {
            changeStartIndex.bind(viewModel)();
            currentPageMessages.bind(viewModel)();
            showLinks.bind(viewModel)()
        })
        viewModel.currentPage(1);

        changePagesCount.bind(viewModel)();

        function currentPageMessages() {
            this.currentMessages(this.allMessages().slice(this.startIndex(), this.startIndex() + this.messagesPerPage()));
        }

        function changeStartIndex() {
            this.startIndex(this.currentPage() * this.messagesPerPage() - this.messagesPerPage());
        }

        function changePagesCount() {
            let pagesCount = Math.ceil(this.allMessages().length / this.messagesPerPage());
            let resultArray = [];
            for (let i = 1; i <= pagesCount; i++) {
               resultArray.push(i);
            }
            this.pagesCountArray(resultArray);
        }

        function showLinks() {
            let currentPage = this.currentPage();
            if (currentPage == 1) {
                this.showPrevLink(false);
            } else {
                this.showPrevLink(true)
            }
            if (currentPage == this.pagesCountArray().length) {
                this.showNextLink(false);
            } else {
                this.showNextLink(true)
            }
        }

        ko.applyBindings(viewModel);
    }
});