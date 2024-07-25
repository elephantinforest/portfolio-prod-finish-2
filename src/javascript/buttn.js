$(document).ready(function () {
    // リスト項目がクリックされたときの処理を定義
    function animateListItemOnClick() {
        $('#buttn').on('click', 'li', function () {
            var hiddenValue = $(this).find("input[type='hidden']").val()
            // クリックされたリスト項目の親要素にクラスを追加
            console.log(hiddenValue)
            $("input[name='register_id'][value='" + hiddenValue + "']")
                .parent()
                .addClass(
                    'animate-ping animate-thrice animate-ease-linear animate-normal animate-fill-both',
                )

            // 3秒後にクラスを削除するタイマーを設定
            setTimeout(function () {
                $("input[name='register_id'][value='" + hiddenValue + "']")
                    .parent()
                    .removeClass(
                        'animate-ping animate-thrice animate-ease-linear animate-normal animate-fill-both',
                    )
            }, 3000) // 3000ミリ秒 = 3秒
        })
    }

    // 関数を呼び出し
    animateListItemOnClick()

    const $target = $('#buttn')

    // MutationObserver の設定
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            // 子ノードが追加された場合
            if (mutation.type === 'childList') {
                // 追加されたノードが li 要素の場合
                $(mutation.addedNodes)
                    .filter('li')
                    .each(function () {
                        console.log('ファイフラッシュ')
                        animateListItemOnClick(this)
                    })
            }
        })
    })

    // 監視を開始
    observer.observe($target[0], { childList: true, subtree: true })
})
