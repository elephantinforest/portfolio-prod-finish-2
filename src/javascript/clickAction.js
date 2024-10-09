$(document).ready(function () {
    $('#omae').click(function () {
        // aria-expanded属性の値をトグルする
        $(this).attr('aria-expanded', function (index, attr) {
            return attr === 'true' ? 'false' : 'true'
        })
        var inputValue = $('.header_locationname').text()
        // oreの表示状態を切り替える
        $('.ore').removeClass('translate-x-full')
        $('#closeButtn').show()
        $('#search').hide()
        $('#inputButtn').hide()
        $('#omae').hide()
    })
    $('#closeButtn').click(function () {
        // aria-expanded属性の値をトグルする
        $(this).attr('aria-expanded', function (index, attr) {
            return attr === 'true' ? 'false' : 'true'
        })
        // oreの表示状態を切り替える
        $('.ore').addClass('translate-x-full')
        $('#closeButtn').hide()
        $('#search').show()
        $('#inputButtn').show()
        $('#omae').show()
    })

    $('.smallLocationButtn').click(function () {
        let window123 = $(window).width()
        // oreの表示状態を切り替える
        var isHidden = $('.smallRegisterButtn').is(':hidden')
        var inputValue = $('.header_locationname').text()
        if (
            $('.moveLocation').is(':hidden') &&
            inputValue.includes('ロケーションは登録されていません')
        ) {
            $('.moveLocation').show()
            $('.registerHide').show()
            $('#closeButtn').show()
        } else if (inputValue.includes('ロケーションは登録されていません')) {
            $('.registerButtn').hide()
            $('#closeButtn').hide()
            $('.moveLocation').hide()
            $('.registerHide').hide()
        } else {
            if (window123 < 1020) {
                if (isHidden) {
                    $('.moveLocation').show()
                    $('.registerHide').show()
                    $('.smallRegisterButtn').show()
                    $('#closeButtn').show()
                    $('.registerde').show()
                } else if (!isHidden) {
                    $('#closeButtn').hide()
                    $('.smallRegisterButtn').hide()
                    $('.moveLocation').hide()
                    $('.registerHide').hide()
                    $('.registerde').hide()
                }
            }
        }
    })

    $('.smallRegisterButtn').click(function () {
        let window123 = $(window).width()
        var isHidden = $('.smallLocationButtn').is(':hidden')
        if (isHidden) {
            $('.moveLocation').show()
            $('.smallLocationButtn').show()
            $('.locationHide').show()
            $('#closeButtn').show()
            $('.registerHide').addClass('mr-10')
            $('.registerde').show()
        } else if (!isHidden) {
            $('.smallLocationButtn').hide()
            $('.locationHide').hide()
            $('#closeButtn').hide()
            // $('.locationButtn').hide()
            $('.moveLocation').hide()
            $('.registerHide').removeClass('mr-10')
            $('.registerde').hide()
        }
    })
    $('.registerButtn').click(function () {
        var isHidden = $('.locationButtn').is(':hidden')
        if (isHidden) {
            $('.pageButtn').show()
            $('.locationHide').show()
            $('.registerHide').addClass('mr-10')
            $('.registerde').show()
            if (!$('.formRegister').is(':hidden')) {
                $('.formRegister').slideUp()
            }

        } else if (!isHidden) {
            $('.pageButtn').hide()
            $('.locationHide').hide()
            // $('.moveLocation').hide()
            if ($('.formRegister').is(':hidden')) {
                $('.formRegister').slideDown()
            }
            $('.registerHide').removeClass('mr-10')
            $('.registerde').hide()
        }
    })
    $('.wideLocationButtn').click(function () {
        // const buttn = '.register'
        // buttnController(buttn)
        var isHidden = $('.registerButtn').is(':hidden')

        if (isHidden) {
            $('.registerHide').show()
            $('.registerButtn').show()
            $('.registerde').show()
            $('.pageButtn').show()
            var inputValue = $('.header_locationname').text()
            if (inputValue.includes('ロケーションは登録されていません')) {
                // 条件がtrueの場合の処理
                $('.register').hide()
            }
        } else if (!isHidden) {
            $('.registerButtn').hide()
            $('.registerHide').hide()
            $('.registerde').hide()
            $('.pageButtn').hide()
            $('.formLocation').show()
            var inputValue = $('.header_locationname').text()
            if (!inputValue.includes('ロケーションは登録されていません')) {
                // 条件がtrueの場合の処理
                $('.register').hide()
                // $('.formLocation').hide()
            }
        }
    })
    function buttnController(buttn) {
        const isHidden = $(buttn).css('display') === 'none'
        const windowWidth = $(window).width()
        let elementsToToggle

        if (windowWidth < 1020) {
            elementsToToggle = $('.registerde,' + buttn)
        } else {
            elementsToToggle = $('.registerde, .pageButtn,' + buttn)
        }

        if (isHidden) {
            elementsToToggle.show()
            $('#userLocation').removeClass('hidden')
        } else {
            $('#userLocation').addClass('hidden')
            elementsToToggle.hide()
        }
    }

    $('.register').click(function () {
        const buttn = '.wideLocationButtn'
        buttnController(buttn)
    })
})
