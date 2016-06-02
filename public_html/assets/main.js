require(
    [
        'less',
        'knockout-es5',
        // 'pager',
        'app/app',
        'common/gridview'
        // 'jquery-ui/dialog',
        /*'knockout-jqueryui/dialog',
        'app/room-categories',
        'app/rooms'*/
    ],
    function(less, ko, app) {
        var vm = function () {
            var self = this;
            this.roomCategories = false;
            this.rooms= false;

            this.list = [];
            this.columns = [
                {
                    name: 'id',
                    label: 'ID'
                },
                {
                    name: 'name',
                    label: 'Name',
                    search: true
                },
                {
                    name: 'isAvailable',
                    label: 'Available',
                    type: 'boolean'
                },
                {
                    name: 'roomCategory.name',
                    label: 'Категория'
                }
            ];

            ko.track(this);

            app.rest.list('Room', function(response) {
                self.list = response;
            });

            this.showRoomCategories = function () {
                self.roomCategories = true;
            };
            this.hideRoomCategories = function () {
                self.roomCategories = false;
            };
            this.showRooms = function () {
                this.rooms = true;
            };
            this.hideRooms = function () {
                this.rooms = false;
            };






            this.log = function (val) {
                console.log(val);
            };
        };

        ko.applyBindings(new vm());

        // var viewModel = new vm();
        // pager.extendWithPage(viewModel);
        // ko.applyBindings(viewModel);
        // pager.start();

    }
);
