$('nav.main li').click(
    function() {
        var el = this;

        $('nav.main li').removeClass('active');
        $(el).addClass('active');

        if ($(el).attr("id") == "mnuLogout") {
            $(location).attr('href', Routing.generate("get_dependent_menu",  {'activeMenu': $(el).attr("id")}))
        } else {
            $('nav.dependent').html("");
            $.get(
                Routing.generate("get_dependent_menu",  {'activeMenu': $(el).attr("id")}),
                function(data, status) {
                    if (status == "success") {
                        $('nav.dependent').html(data);
                        $('nav.dependent li').click(dependentMenuClickFun);
                    }
                }
            );
        }
    }
);

var dependentMenuClickFun = function() {
    var el = this;
    $('nav.dependent li').removeClass('active');
    $(el).addClass('active');
};
$('nav.dependent li').click(dependentMenuClickFun);    
