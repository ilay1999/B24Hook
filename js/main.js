
// Направить данные
function sendData() {
        let  dealData = {
            'firm': document.getElementById('firm').value,
            'creator': document.getElementById('creator').value,
            'ttl': document.getElementById('ttl').value,
        };  

        $.ajax ({
            url: "sendContorller.php",
            type: "POST",
            data: {
                func: 1,
                dealData: dealData,                                              
            },                
            dataType: "html",
            success:  function(){
                destroy('main');
                document.getElementById('main').innerHTML = '<p class="done">Сделка создана</p>';
                }
        });
};
// Фукнция созданная для очистки элементов
function destroy(destroyTo){
    document.getElementById(destroyTo).innerHTML = "";
};
