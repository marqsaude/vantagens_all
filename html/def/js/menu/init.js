/*
	Interphase by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
*/
(function($) {

	skel.init({
		reset: 'full',
		breakpoints: {
			global: {
				href: 'def/css/menu/style.css',
				containers: 1400,
				grid: { gutters: ['2em', 0] }
			},
			xlarge: {
				media: '(max-width: 1680px)',
				href: 'def/css/menu/style-xlarge.css',
				containers: 1200
			},
			large: {
				media: '(max-width: 1280px)',
				href: 'def/css/menu/style-large.css',
				containers: 960,
				grid: { gutters: ['1.5em', 0] },
				viewport: { scalable: false }
			},
			medium: {
				media: '(max-width: 980px)',
				href: 'def/css/menu/style-medium.css',
				containers: '90%'
			},
			small: {
				media: '(max-width: 736px)',
				href: 'def/css/menu/style-small.css',
				containers: '90%',
				grid: { gutters: ['1.25em', 0] }
			},
			xsmall: {
				media: '(max-width: 480px)',
				href: 'def/css/menu/style-xsmall.css'
			}
		},
		plugins: {
			layers: {
				config: {
					mode: 'transform'
				},
				navPanel: {
					animation: 'pushX',
					breakpoints: 'medium',
					clickToHide: false,
					height: '100%',
					hidden: true,
					html: '<div data-action="moveElement" data-args="nav"></div>',
					orientation: 'vertical',
					position: 'top-left',
					side: 'left',
					width: 250
				},
				navButton: {
					breakpoints: 'medium',
					height: '4em',
					html: '<span class="toggle" data-action="toggleLayer" data-args="navPanel"></span>',
					position: 'top-left',
					side: 'top',
					width: '6em'
				}
			}
		}
	});

	$(function() {

		// ...

	});

})(jQuery);

function openMobileLogin(){
	$(function (){
        $(".modal-backdrop").show();
        $("#dialog_mobile_login").show();
	});
}
$(function (){
	$("#black-mask-mobile").click(function () {
        closeLoginMobile();
	});
	$("#btn_login_mobile").click(function () {
		$("#form-login-mobile").submit();
    });
});

function closeLoginMobile() {
    $(".modal-backdrop-mobile").hide();
    $("#dialog_mobile_login").hide();
}

function loginMobile(obj){
    var array = {"nm_login":obj.user.value, "nm_senha":obj.passwd.value};
    ajaxPost(funcaoLoginMobile, array, "/login/logar/", "/admin");
    return false;
}

var funcaoLoginMobile = function(json){
    if(json != ""){
        if(json.type==2){
            alert(json.msg);
        }else{
            window.location.href = getUrlController() + "/admin/index";
        }
    }
};