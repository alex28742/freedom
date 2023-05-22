// # МЕТОД ОБРАБОТКИ ФОРМЫ ПО AJAX
/*
Пример формы с которой работает код:
    <div class="result_error"></div>
    <div class="result"></div>
    <form class='form ajax' action='/cards/cloud' method='post'>
        <input class="form-control" type="text" name="input" required/>
        <button type="submit" class="">Отправить</button>
    </form>
*/
$(document).on('submit','.form.ajax', function(event){
    event.preventDefault();
    let $form = $(this);
    $required = $form.find('[data-required]'); // отбор обязательных полей
    let isError = false; // сохранение ошибок
    // удаляю классы ошибок
    $('input.error').removeClass('error');
    // удаляю общий блок ошибок
    $('.result_error').remove();
    // удаляю блок ошибки поля
    $('.field-error').remove();
    // перебираю обязательные поля и проверяю на заполнение

    $.each($required, function(i, val){
        console.log('inner each');
        // если чек-бокс обязателен, но не отмечен
        if($(this).attr('type') === 'checkbox' && !$(this).is(':checked')){
            isError = true;
            $(this).addClass('error');
        }
        // если свойство не чек-бокс, обязательно, но не заполнено
        if($.trim($(this).val()) === "" && $(this).attr('type') !== 'checkbox'){
            isError = true;
            $(this).addClass('error'); // класс для самого элемента
            // добавляю надпись
            $('<div class="field-error">Заполните это поле</div>').insertAfter($(this));
        }
    });


    // если нет ошибок, передаю данные
    if(!isError){
        $.ajax({
            url: $form.attr('action'), // куда будет идти запрос
            type: $form.attr('method'), // метод передачи данных
            data: $form.serialize(), // данные которые хотим получить
            success: function(res){ // что делаем при получении ответа
                // $('#answer').html(res);
                //console.log('отработал ajax.js');
                $('.result').show();
                if(res) {
                    // если вернул результат. значит ошибки
                    $('.result').html("<div class='alert alert-danger'>"+res+"</div>");
                }
                else{
                    // если не вернул результат, значит все ок
                    $('.result').html("<div class='alert alert-success'>Успешно!</div>");
                }
            },
            error: function(){ // если возникла ошибка
                $('.result').html("<div class='alert alert-danger'>Отправка не удалась((</div>");
            }
        });
    }
    return false;
});