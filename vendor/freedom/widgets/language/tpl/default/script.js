$(function(){
    $('#lang').change(function(){
        // передаем в контроллер выбранный язык
        window.location = '/language/change?lang=' + $(this).val();
    });
});