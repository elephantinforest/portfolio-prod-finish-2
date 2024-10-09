export function makeRegisterList(register) {
    return `
        <li id="registerde" class="registerde z-30 ui-sortable-handle" style="position: absolute; left: ${register['left_position']}%; top: ${register['top_position']}px;">
    <a class="parent" href="/update?id=${register['register_id']}" style="width: ${register['width']}px; height: ${register['height']}px;">
        <div class="ui-wrapper" style="overflow: hidden; position: relative; width: 100%; height: 100%;">
            <img id="registerContainer" class=" img opacity-85 rounded-lg grayscale hover:contrast-200 hover:grayscale-0" alt="画像の説明" src="${register['file_path']}" style="width: ${register['width']}px; height: ${register['height']}px;">
        </div>
        <input type="hidden" name="register_id" value="${register['register_id']}">
    </a>
    <input type="hidden" name="window_width" value="${register['window_width']}">
    <input type="hidden" name="window_height" value="${register['window_height']}">
</li>
    `
}

export function makeButtnList(register) {
    return `<li class = "delete text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 cursor-pointer">
    <input type="hidden" name="label_register" value="${register['register_id']}">${register['name']}</li>`
}

export function sendAlert(errors) {
    if (typeof errors === 'string') {
        alert(errors)
    } else {
        let mesage = []
        $.each(errors, function (index, element) {
            mesage.push(element) // 配列に要素を追加
            mesage.push('\n') // 段落を区切るための改行を追加
        })
        alert(mesage)
    }
}

export function searchNumber(positions) {
    var parentLi = $(
        'input[name="register_id"][value="' + positions.registerId + '"]',
    ).closest('li')

    // li タグが見つかった場合、left の値を変更する
    if (parentLi.length > 0) {
        parentLi.css('left', positions.x + '%')
    } else {
       
    }
}
