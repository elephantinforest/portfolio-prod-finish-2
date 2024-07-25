$(function () {
    // ドラッグ可能な機能を適用する関数
    function applyResizable(element) {
        const currentWindowWidth = $(window).width()
        const currentWindowHeight = $('body').height()
        console.log(currentWindowHeight)
        console.log(currentWindowWidth)

        // console.log(element)
        $(element).each(function() {
             $('.img').resizable()
        })
         $('.img').resizable({
             stop: function (event, ui) {
                 // リサイズ終了時の処理

                 const width = $(this).width()
                 const height = $(this).height()
                 const registerId = $(this)
                     .closest('.parent')
                     .find('input[name="register_id"]')
                     .val()
                 const data = {
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
                         responsiveDesign() // この関数の定義は不明
                     },
                     error: function (xhr, status, error) {
                         console.log('Error:', error)
                     },
                 })
             },
         })
    }

    // ドキュメントが読み込まれた時に実行される初期化処理
    // 既存の要素にドラッグ可能な機能を適用する
    applyResizable($('.img'))
    // MutationObserver を使用して新しい要素の挿入を監視
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'childList') {
                // 新しい要素が .registerde クラスを持つ場合、ドラッグ可能な機能を適用
                mutation.addedNodes.forEach((node) => {
                    if ($(node).hasClass('registerde')) {
                        applyResizable($(node))
                    }
                })
            }
        })
    })

    // body 要素に対して MutationObserver を開始
    observer.observe(document.body, {
        childList: true,
        subtree: true,
    })
})
