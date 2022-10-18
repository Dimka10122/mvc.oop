define([
    'assets/js/scripts/lib/knockout',
    'assets/js/scripts/modules/pagination',
    'assets/js/scripts/modules/dropdown'
], function (ko, pagination, dropdown) {
    return function (items) {
        let globalViewModel = {
            dropdownViewModel: dropdown(),
            paginationViewModel: pagination(items),
        };

        ko.applyBindings(globalViewModel);
    }
});