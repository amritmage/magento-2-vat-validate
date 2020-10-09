define([
    'underscore',
    'jquery',
    'uiRegistry',
    'ko',
    'Magento_Ui/js/form/element/abstract',
    'Magento_Ui/js/modal/modal',
    'mage/url'
],  function (_, $, uiRegistry, ko, Component, urlBuilder) {
    'use strict';
   return Component.extend({       
        isShowVatValidButton: ko.observable(false),        
        validateVatNo: function (){
            var countryCode = $('select[name=country_id]').val();
            var vatNumber = $('input[name=vat_id]').val();
            var origin   = window.location.origin;
            var customurl = origin + '/checkvat/index/index';
            $.ajax({
                url: customurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    countryCode: countryCode,
                    vatNumber: vatNumber,
                },
                success: function(response) { 
                    $('#vatValidate').css('background-color', response.style);
                    $('#vatValidate span').html(response.message);
                },
                error: function (xhr, status, errorThrown) {
                    console.log('Error happens. Try again.');
                }
            });
        },
        onUpdate: function(){
            var self = this;
            this._super();
            if(this.checkInvalid()){                                
                self.isShowVatValidButton(false);
            } else {                
                self.isShowVatValidButton(true);
            }
        }       
    });
});