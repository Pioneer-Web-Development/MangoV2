/**
 * Created by jhansen on 9/17/2015.
 */
(function ($, window) {

    $.fn.contextMenu = function (settings) {

        return this.each(function () {

            // Open context menu
            $(this).on("contextmenu", function (e) {
                // return native menu if pressing control
                if (e.ctrlKey) return;

                //open menu
                var $menu = $(settings.menuSelector)
                    .data("invokedOn", $(e.target))
                    .show()
                    .css({
                        position: "absolute",
                        left: getMenuPosition(e.clientX, 'width', 'scrollLeft'),
                        top: getMenuPosition(e.clientY, 'height', 'scrollTop')
                    })
                    .off('click')
                    .on('mouseover', 'li', function (e) {
                        $(e.currentTarget).addClass('active');
                    })
                    .on('mouseout', 'li', function (e) {
                        $(e.currentTarget).removeClass('active');
                    })
                    .on('click', 'a', function (e) {
                        $menu.hide();

                        var $invokedOn = $menu.data("invokedOn");
                        var $selectedMenu = $(e.target);

                        settings.menuSelected.call(this, $invokedOn, $selectedMenu);
                    });
                return false;
            });

            //make sure menu closes on any click
            $(document).click(function () {
                $(settings.menuSelector).hide();
            });
        });

        function getMenuPosition(mouse, direction, scrollDir) {
            var win = $(window)[direction](),
                scroll = $(document)[scrollDir](),
                menu = $(settings.menuSelector)[direction](),
                position = mouse + scroll;

            // opening menu would pass the side of the page
            if (mouse + menu > win && menu < mouse)
                position -= menu;
            return position;

        }

    };
})(jQuery, window);

/*
SAMPLE IMPLEMENTATION
 <!-- please note to add data-action on the <i> as well as the <a> because I didn't fix that in the pioneer/contextMenu.js file... -->
menu markup
 <ul id="pressCalendarContextMenu" class="dropdown-menu" role="menu">
 <li><a tabindex="-1" data-action="edit"><i class="fa fa-pencil" data-action="edit"></i> Edit</a></li>
 <li class="divider"></li>
 <li><a tabindex="-1" data-action="delete"><i class="fa fa-trash" data-action="delete"></i> Delete</a></li>
 </ul>

script call:
 $("#myTable td").contextMenu({
 menuSelector: "#contextMenu",
 menuSelected: function (invokedOn, selectedMenu) {
 var msg = "You selected the menu item '" + selectedMenu.text() +
 "' on the value '" + invokedOn.text() + "'";
 alert(msg);
 }
 });
 */