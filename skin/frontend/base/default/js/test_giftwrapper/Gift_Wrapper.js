/**
 * @author      Andrey Makienko <makyshplat@gmail.com>
 */
var Gift_Wrapper = (function ($) {

    return {

        ajax_url: null,
        errorElem: '<ul class="messages"><li class="error-msg"><ul><li><span>{{message}}</span></li></ul></li></ul>',
        successElem: '<ul class="messages"><li class="success-msg"><ul><li><span>{{message}}</span></li></ul></li></ul>',
        elemMessage:'.col-main',

        /* Module initialization */
        init: function () {
            var $row = $('#shopping-cart-table');

            $row.find('input.gift_wrapper_checkbox').change( function () {
                var self = this;
                var params = {
                    parent_item_id: self.id,
                    product_id: self.dataset.productId,
                    item_id:self.dataset.itemId,
                    action_item:(self.checked) ? 'add' : 'remove'
                };
                $j("#gift-wrapper-wait").show();
                Gift_Wrapper.addItemToCart(params);

            });

        },
        /**
         *
         * @param params
         */
        addItemToCart: function (params) {
            $j.ajax({
                type: 'POST',
                dataType: 'json',
                data: params,
                url: Gift_Wrapper.ajax_url,
                showLoader: true
            }).done(function (result) {
                var successMessage = result['message'];
                var element = $(Gift_Wrapper.successElem.replace('{{message}}', successMessage));
                $(Gift_Wrapper.elemMessage).before(element).show();
                setTimeout(function () {
                    element.fadeOut(function () {
                        element.remove();
                    });
                }, 3000);
                $j("#gift-wrapper-wait").hide();

            }).error(function (result) {
                var errorMessage = result.responseJSON.message;
                var element = $(Gift_Wrapper.errorElem.replace('{{message}}', errorMessage));
                $(Gift_Wrapper.elemMessage).before(element).show();
                setTimeout(function () {
                    element.fadeOut(function () {
                        element.remove();
                    });
                }, 3000);
                $j("#gift-wrapper-wait").hide();

            });
        }
    }

}(jQuery));
