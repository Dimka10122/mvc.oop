define([
    'assets/js/scripts/lib/knockout',
    'assets/js/scripts/modules/pagination',
    'assets/js/scripts/modules/dropdown'
], function (ko, pagination, dropdown) {
    return function (items) {
        let actions = ['Select All', 'Unselect All', 'Select This Page', 'Unselect This Page'];

        let globalViewModel = {
            paginationViewModel: pagination(items),
            dropdownViewModel: dropdown(actions),
        };

        ko.applyBindings(globalViewModel);
    }
});