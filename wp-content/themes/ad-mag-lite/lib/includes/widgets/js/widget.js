/*
 * http://kopatheme.com
 * Copyright (c) 2014 Kopatheme
 *
 * Licensed under the GPL license:
 *  http://www.gnu.org/licenses/gpl.html
 */

 jQuery.fn.extend({
    insertAtCaret: function(myValue, myValueE){
        return this.each(function(i) {
            if (document.selection) {
                //For browsers like Internet Explorer
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue + myValueE;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                //For browsers like Firefox and Webkit based
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0,     startPos)+myValue+this.value.substring(startPos,endPos)+myValueE+this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = ((startPos + myValue.length) + this.value.substring(startPos,endPos).length);
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        })
    }
});

jQuery.fn.caret = function (begin, end){
    if (this.length == 0) return;
    if (typeof begin == 'number'){
        end = (typeof end == 'number') ? end : begin;
        return this.each(function (){
            if (this.setSelectionRange)
            {
                this.setSelectionRange(begin, end);
            } else if (this.createTextRange){
                var range = this.createTextRange();
                range.collapse(true);
                range.moveEnd('character', end);
                range.moveStart('character', begin);
                try {
                    range.select();
                } catch (ex) { }
            }
        });
    }else{
        if (this[0].setSelectionRange)
        {
            begin = this[0].selectionStart;
            end = this[0].selectionEnd;
        } else if (document.selection && document.selection.createRange){
            var range = document.selection.createRange();
            begin = 0 - range.duplicate().moveStart('character', -100000);
            end = begin + range.text.length;
        }
        return {
            begin: begin, 
            end: end
        };
    }
}
function kopa_change_timeline(obj){
    if(jQuery(obj).val() == 'portfolio'){
        jQuery(obj).parent().parent().find(".kopa-wdt-category").hide();
        jQuery(obj).parent().parent().find(".kopa-wdt-and-or").hide();
        jQuery(obj).parent().parent().find(".kopa-wdt-tags").hide();
        jQuery(obj).parent().parent().find(".kopa-wdt-number-of-article").hide();
        jQuery(obj).parent().parent().find(".kopa-wdt-order-by").hide();
    }
    else{
        jQuery(obj).parent().parent().find(".kopa-wdt-category").show();
        jQuery(obj).parent().parent().find(".kopa-wdt-and-or").show();
        jQuery(obj).parent().parent().find(".kopa-wdt-tags").show();
        jQuery(obj).parent().parent().find(".kopa-wdt-number-of-article").show();
        jQuery(obj).parent().parent().find(".kopa-wdt-order-by").show();
    }    
}

jQuery(document).ready(function() {
    jQuery(".kopa-wdt-select-timeline").each(function(){
        if(jQuery(this).val() == 'portfolio'){
        jQuery(this).parent().parent().find(".kopa-wdt-category").hide();
        jQuery(this).parent().parent().find(".kopa-wdt-and-or").hide();
        jQuery(this).parent().parent().find(".kopa-wdt-tags").hide();
        jQuery(this).parent().parent().find(".kopa-wdt-number-of-article").hide();
        jQuery(this).parent().parent().find(".kopa-wdt-order-by").hide();
    }
    else{
        jQuery(this).parent().parent().find(".kopa-wdt-category").show();
        jQuery(this).parent().parent().find(".kopa-wdt-and-or").show();
        jQuery(this).parent().parent().find(".kopa-wdt-tags").show();
        jQuery(this).parent().parent().find(".kopa-wdt-number-of-article").show();
        jQuery(this).parent().parent().find(".kopa-wdt-order-by").show();
    }    
        
    });    
});

