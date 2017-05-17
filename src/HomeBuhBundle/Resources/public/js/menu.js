var initContentFun = function(el) {
    var elContent = $('section.main div.content');
    fillElement(elContent, function() {
        initElements();
    }, "get_content", {'activeMenu': $(el).attr("id")});
};

var dependentMenuClickFun = function() {
    var el = this;
    $('nav.dependent li').removeClass('active');
    $(el).addClass('active');

    initContentFun(el);
};

$('nav.dependent li').click(dependentMenuClickFun);

$('nav.main li').click(
    function() {
        var el = this;

        $('nav.main li').removeClass('active');
        $(el).addClass('active');

        if ($(el).attr("id") == "mnuLogout") {
            $(location).attr('href', Routing.generate("get_dependent_menu",  {'activeMenu': $(el).attr("id")}))
        } else {
            $('nav.dependent').html("");
            var elDepMenu = $('nav.dependent');
            fillElement(elDepMenu, function(){
                $('nav.dependent li').click(dependentMenuClickFun);
            }, "get_dependent_menu", {'activeMenu': $(el).attr("id")});

            initContentFun(el);
        }
    }
);