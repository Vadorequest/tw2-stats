<script>
    $(document).ready(function(){
        $.ajax({
            url: 'http://beta.api.gorod55.ru/search/realty',
            type: 'POST',
            dataType: 'json',
            data: {
                '{"SessionID":"6c6c7336-0a72-4f6b-87e0-26c19056c92a","ID":"6c0cbc50-120e-4fa7-e92a-fe423f8f4743","IsRequest":true,"Type":"Search","FullTextSearchRequest":"Квартира Сдам в аренду","Domain":"Realty","MessageMapKey":"realty_Search","Order":[{"Field":"IsTop","Reverse":true},{"Field":"PrimaryOrder","Reverse":true}],"Page":0,"Count":10}': ''
                '{"SessionID":"6c6c7336-0a72-4f6b-87e0-26c19056c92a","ID":"06a29cd0-1631-4cf8-fae1-7d35c1db6154","IsRequest":true,"Type":"Search","FullTextSearchRequest":"Квартира Сдам в аренду","Domain":"Realty","MessageMapKey":"realty_Search","Order":[{"Field":"IsTop","Reverse":true},{"Field":"PrimaryOrder","Reverse":true}],"Page":0,"Count":10'
            },
            success: function(data) {
                console.log(data);
            }
        });
    });
</script>