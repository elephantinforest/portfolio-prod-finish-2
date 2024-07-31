$(document).ready(function () {
    // ボタンがクリックされた時の処理

    addSize()
    resizableWindow()
    responsiveDesign()



    function addSize() {
        var currentWindowWidth = $(window).width()
        var currentWindowHeight = $('body').height()
        $('.windowWidthInput').val(currentWindowWidth)
        $('.windowHeightInput').val(currentWindowHeight)
    }
    function handleWidthChange(className) {
        // 監視する要素の初期の幅を取得
        var initialWidth = $('.' + className).width()

        // 要素の幅が変更されたときに実行される関数
        function checkWidth() {
            // 現在の幅を取得
            var currentWidth = $('.' + className).width()

            // 初期の幅と現在の幅が異なる場合は、幅を100%に設定する
            if (initialWidth !== currentWidth) {
                // 幅を100%に設定する
                $('.' + className).css('width', '100%')
            }
        }

        // ウィンドウのリサイズイベントを監視して、幅が変更されたら対処する
        $(window).on('resize', checkWidth)
    }
    // クラス名を引数として関数を呼び出す
    handleWidthChange('registerHide')
    handleWidthChange('locationHide')

    function observeWidthChanges(targetSelector) {
        // 監視する要素を取得
        var targetElement = $(targetSelector)[0]

        // 初期の幅を取得

        // CSSの変更を監視する関数
        function observeCssChanges() {
            // 現在の幅を取得
            var currentWidth = $(targetElement).width()

            // 幅が0pxに変更された場合、幅を100%に戻す
            if (currentWidth === 0) {
                $(targetElement).css('width', '100%')
            }
        }

        // 一定の間隔でCSSの変更を監視
        setInterval(observeCssChanges, 500) // 500ミリ秒ごとに監視
    }

    // 関数を呼び出して、監視する要素のセレクタを渡す
    observeWidthChanges('.registerHide')
    observeWidthChanges('.locationHide')
})
