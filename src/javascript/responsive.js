function applyResizable(element) {
    var currentWindowWidth = $(window).width()
    var currentWindowHeight = $('body').height()
    console.log(currentWindowHeight)
    console.log(currentWindowWidth)
    $('.img').resizable({
        stop: function (event, ui) {
            // リサイズ終了時の処理
            var width = $(this).width()
            var height = $(this).height()
            var registerId = $(this)
                .closest('.parent')
                .find('input[name="register_id"]')
                .val()
            var data = {
                width: width,
                height: height,
                registerId: registerId,
                windowWidth: currentWindowWidth,
                windowHeight: currentWindowHeight,
            }
            $.ajax({
                url: '/resize',
                method: 'POST',
                data: { data: data },
                success: function (response) {
                    console.log('Success:', response)
                    responsiveDesign()
                },
                error: function (xhr, status, error) {
                    console.log('Error:', error)
                },
            })
        },
    })
}

export function responsiveDesign() {
    $('ul')
        .find('li')
        .each(function () {
            var currentLi = $(this) // 現在のli要素を指す変数
            console.log(currentLi)
            var initialWindowWidth = $(window).width()
            var initialWindowHeight = $('body').height()
            var initialWidth = $(currentLi).find('img').width()
            var initialHeight = currentLi.find('img').height()
            console.log('Initial Window Height:', initialWindowHeight)

            var $element = $(
                '.registerde.ui-sortable-handle[style*="position: absolute;"]',
            )
            console.log('Initial Top Value:', currentLi.css('top'))

            var leftValue =
                (parseFloat(currentLi.css('left')) / initialWindowWidth) * 100
            var initialTopPercentage = parseInt(currentLi.css('top'), 10)
            console.log('Initial Left Percentage:', leftValue)
            console.log('Initial Top Percentage:', initialTopPercentage)
            $(window).on('resize', function () {
                var currentWindowWidth = $(window).width()
                var currentWindowHeight = $('body').height()
                console.log('initial: ' + currentWindowHeight)

                var topScaleY = currentWindowWidth / initialWindowWidth
                var scaleX = currentWindowWidth / initialWindowWidth
                var scaleY = currentWindowHeight / initialWindowHeight
                var newLeft = leftValue * scaleX + '%'
                var newTop = initialTopPercentage * topScaleY + 'px'
                console.log(currentWindowWidth)

                if (currentWindowWidth > 390) {
                    currentLi.css('top', newTop) // topの値を変更
                } else {
                    newTop = initialTopPercentage - 33
                    currentLi.css('top', newTop + 'px') // topの値を変更
                }
                console.log('width::' + currentLi.width())
                console.log('height::' + currentLi.height())

                // 新しい幅と高さを計算
                var newWidth = initialWidth * scaleX
                var newHeight = initialHeight * scaleY
                console.log('X::' + scaleX)
                console.log('Y::' + scaleY)

                var imgWidth = newWidth + 'px'
                var imgHeight = newHeight + 'px'
                console.log('width:' + imgWidth)
                console.log('height:' + imgHeight)
                // 幅と高さの値を設定
                currentLi.css({
                    width: imgWidth,
                    height: imgHeight,
                })

                currentLi.find('.ui-wrapper').css({
                    width: imgWidth,
                    height: imgHeight,
                })
                currentLi.find('.img').css({
                    width: imgWidth,
                    height: imgHeight,
                })
                currentLi.find('.parent').css({
                    width: imgWidth,
                    height: imgHeight,
                })

                applyResizable($('.img'))
                $('.windowWidthInput').val(currentWindowWidth)
                $('.windowHeightInput').val(currentWindowHeight)
                console.log(
                    'Window Width Input Value: ' + $('.windowWidthInput').val(),
                )
                console.log(
                    'Window Height Input Value: ' +
                        $('.windowHeightInput').val(),
                )
                currentLi.find('.window_width').val(currentWindowWidth)
                currentLi.find('.window_height').val(currentWindowHeight)
            })

            $('#registersItem').on('resize', function (event) {
                event.stopPropagation()
            })
        })
}

export function resizableWindow() {
    // 対象の要素（registerdeクラスを持つ要素）に対して操作を行う
    $('.registerde').each(function () {
        var currentLi = $(this)

        var windowHeight = currentLi.find('input[name="window_height"]').val()
        var windowWidth = currentLi.find('input[name="window_width"]').val()

        console.log('window_height: ' + windowHeight)
        console.log('window_width: ' + windowWidth)

        var initialTopPercentage = parseInt(currentLi.css('top'), 10)
        var currentWindowWidth = $(window).width()
        var currentWindowHeight = $('body').height()
        var scaleX = currentWindowWidth / windowWidth
        var scaleY = currentWindowHeight / windowHeight
        var newTop = initialTopPercentage * scaleY + 'px'

        currentLi.css('top', newTop)
        console.log('width::' + currentLi.width())
        console.log('height::' + currentLi.height())

        var newWidth = currentLi.width() * scaleX
        var newHeight = currentLi.height() * scaleY
        console.log('newWidth::' + newWidth)
        console.log('newHeight::' + newHeight)

        var imgWidth = newWidth - 6 + 'px'
        var imgHeight = newHeight - 6 + 'px'
        console.log('width:' + imgWidth)
        console.log('height:' + imgHeight)

        // currentLi.find('width').css({
        //     width: imgWidth,
        //     height: imgHeight,
        // })
        currentLi.css('width', imgWidth)
        currentLi.css('height', imgHeight)

        currentLi.find('.ui-wrapper').css({
            width: imgWidth,
            height: imgHeight,
        })
        currentLi.find('.img').css({
            width: imgWidth,
            height: imgHeight,
        })
        currentLi.find('.parent').css({
            width: imgWidth,
            height: imgHeight,
        })

        applyResizable(currentLi.find('.img'))
        // $('.windowWidthInput').val(currentWindowWidth)
        // $('.windowHeightInput').val(currentWindowHeight)
    })

    // 操作が完了したら要素を再表示する
    setTimeout(function () {
        $('.registerde').removeClass('hidden')
    }, 100) // 必要に応じて遅延時間を調整
}
