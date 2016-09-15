(function ($) {
    $(window).load(function () {

        var textareaLineHeight = parseInt($(".textarea_wrap textarea").css("line-height")),
            textarea = $(".textarea_wrap textarea"),
            textareaWrapper = $(".textarea_wrap"),
            textareaClone = $(".textarea_wrap .textarea-clone");

        textarea.bind("keyup keydown", function (e) {
            var $this = $(this), textareaContent = $this.val(), clength = textareaContent.length, cursorPosition = textarea.getCursorPosition();
            textareaContent = "<span>" + textareaContent.substr(0, cursorPosition) + "</span>" + textareaContent.substr(cursorPosition, textareaContent.length);
            textareaContent = textareaContent.replace(/\n/g, "<br />");
            textareaClone.html(textareaContent + "<br />");
            $this.css("height", textareaClone.height());
            var textareaCloneSpan = textareaClone.children("span"), textareaCloneSpanOffset = 0,
                viewLimitBottom = (parseInt(textareaClone.css("min-height"))) - textareaCloneSpanOffset, viewLimitTop = textareaCloneSpanOffset,
                viewRatio = Math.round(textareaCloneSpan.height() + textareaWrapper.find(".mCSB_container").position().top);
            if (viewRatio > viewLimitBottom || viewRatio < viewLimitTop) {
                if ((textareaCloneSpan.height() - textareaCloneSpanOffset) > 0) {
                    textareaWrapper.mCustomScrollbar("scrollTo", textareaCloneSpan.height() - textareaCloneSpanOffset - textareaLineHeight);
                } else {
                    textareaWrapper.mCustomScrollbar("scrollTo", "top");
                }
            }
        });

        $.fn.getCursorPosition = function () {
            var el = $(this).get(0), pos = 0;
            if ("selectionStart" in el) {
                pos = el.selectionStart;
            } else if ("selection" in document) {
                el.focus();
                var sel = document.selection.createRange(), selLength = document.selection.createRange().text.length;
                sel.moveStart("character", -el.value.length);
                pos = sel.text.length - selLength;
            }
            return pos;
        }
    });
})(jQuery);