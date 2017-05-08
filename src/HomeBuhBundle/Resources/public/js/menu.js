(function () {
    var mainMenuClickFun = function() {
        var el = this;
        $('nav.main li').removeClass('active');
        $(el).addClass('active');
    };
    $('nav.main li').click(mainMenuClickFun);

    var dependentMenuClickFun = function() {
        var el = this;
        $('nav.dependent li').removeClass('active');
        $(el).addClass('active');
    };
    $('nav.dependent li').click(dependentMenuClickFun);    
})();
