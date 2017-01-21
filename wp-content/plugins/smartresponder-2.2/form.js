_sr(function() {
    _sr('input[name="subscribe"]').prop('disabled', false);
    var border_color = _sr('input[name="field_name_first"]').css('border-color');
    _sr('input[name="subscribe"]').click(function(){
        if(_sr('input[name="delivery_variant"]').length > 0) { _sr('input[name="did[]"]').remove(); _sr('input[name="delivery_variant"]:checked').each(function() { var deliveryLength = _sr(this).length; for(var i = 0; i < deliveryLength; i++) { var delivery = _sr(this).val(); _sr('.sr-box-list').after('<input type="hidden" name="did[]" value="'+delivery+'" />'); } }); }
        _sr('.sr-box input[type="text"]').css('border-color',border_color); var all_fields_e = 0;
        var field_name_first_e = 0; var field_email_e = 0; var field_name_last_e = 0; var field_name_mid_e = 0; var field_city_e = 0; var field_address_e = 0; var field_phones_e = 0; var field_company_e = 0;
        if(_sr('input[name="field_name_first"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').val() == '') { field_name_first_e = 1; _sr('input[name="field_name_first"]').css('border-color','red'); } else { field_name_first_e = 0; }
        if(_sr('input[name="field_email"]').hasClass('sr-required') && _sr('input[name="field_email"]').val() == '') { field_email_e = 1; _sr('input[name="field_email"]').css('border-color','red'); } else { field_email_e = 0; }
        if(_sr('input[name="field_name_last"]').hasClass('sr-required') && _sr('input[name="field_name_last"]').val() == '') { field_name_last_e = 1; _sr('input[name="field_name_last"]').css('border-color','red'); } else { field_name_last_e = 0; }
        if(_sr('input[name="field_name_mid"]').hasClass('sr-required') && _sr('input[name="field_name_mid"]').val() == '') { field_name_mid_e = 1; _sr('input[name="field_name_mid"]').css('border-color','red'); } else { field_name_mid_e = 0; }
        if(_sr('input[name="field_city"]').hasClass('sr-required') && _sr('input[name="field_city"]').val() == '') { field_city_e = 1; _sr('input[name="field_city"]').css('border-color','red'); } else { field_city_e = 0; }
        if(_sr('input[name="field_address"]').hasClass('sr-required') && _sr('input[name="field_address"]').val() == '') { field_address_e = 1; _sr('input[name="field_address"]').css('border-color','red'); } else { field_address_e = 0; }
        if(_sr('input[name="field_phones"]').hasClass('sr-required') && _sr('input[name="field_phones"]').val() == '') { field_phones_e = 1; _sr('input[name="field_phones"]').css('border-color','red'); } else { field_phones_e = 0; }
        if(_sr('input[name="field_company"]').hasClass('sr-required') && _sr('input[name="field_company"]').val() == '') { field_company_e = 1; _sr('input[name="field_company"]').css('border-color','red'); } else { field_company_e = 0; }
        if(field_name_first_e == 0 && field_email_e == 0 && field_name_last_e == 0 && field_name_mid_e == 0 && field_city_e == 0 && field_address_e == 0 && field_phones_e == 0 && field_company_e == 0) { all_fields_e = 0; } else { all_fields_e = 1; }
        var field_email_w = 0;
        if(_sr('input[name="field_email"]').hasClass('sr-required') && _sr('input[name="field_email"]').hasClass('2')) { var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; var emailaddressVal = _sr('input[name="field_email"]').val(); if(emailaddressVal != '' && !emailReg.test(emailaddressVal)) { field_email_w = 1; _sr('input[name="field_email"]').css('border-color','red'); } else { field_email_w = 0; _sr('input[name="field_email"]').css('border-color',border_color); } }
        var ruReg = /^[а-яА-Я0-9]*$/; var enReg = /^[a-zA-Z0-9]*$/; var all_fields_m_ru = 0; var all_fields_m_latin = 0;
        var field_name_first_m_ru = 0; var field_name_last_m_ru = 0; var field_name_mid_m_ru = 0; var field_city_m_ru = 0; var field_address_m_ru = 0; var field_phones_m_ru = 0; var field_company_m_ru = 0;
        if(_sr('input[name="field_name_first"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('ru')) {  if(!ruReg.test(_sr('input[name="field_name_first"]').val())) { field_name_first_m_ru = 1; _sr('input[name="field_name_first"]').css('border-color','red'); } else { field_name_first_m_ru = 0; _sr('input[name="field_name_first"]').css('border-color',border_color); } }
        if(_sr('input[name="field_name_last"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('ru')) { if(!ruReg.test(_sr('input[name="field_name_last"]').val())) { field_name_last_m_ru = 1; _sr('input[name="field_name_last"]').css('border-color','red'); } else { field_name_last_m_ru = 0; _sr('input[name="field_name_last"]').css('border-color',border_color); } }
        if(_sr('input[name="field_name_mid"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('ru')) { if(!ruReg.test(_sr('input[name="field_name_mid"]').val())) { field_name_mid_m_ru = 1; _sr('input[name="field_name_mid"]').css('border-color','red'); } else { field_name_mid_m_ru = 0; _sr('input[name="field_name_mid"]').css('border-color',border_color); } }
        if(_sr('input[name="field_city"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('ru')) { if(!ruReg.test(_sr('input[name="field_city"]').val())) { field_city_m_ru = 1; _sr('input[name="field_city"]').css('border-color','red'); } else { field_city_m_ru = 0; _sr('input[name="field_city"]').css('border-color',border_color); } }
        if(_sr('input[name="field_address"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('ru')) { if(!ruReg.test(_sr('input[name="field_address"]').val())) { field_address_m_ru = 1; _sr('input[name="field_address"]').css('border-color','red'); } else { field_address_m_ru = 0; _sr('input[name="field_address"]').css('border-color',border_color); } }
        if(_sr('input[name="field_phones"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('ru')) { if(!ruReg.test(_sr('input[name="field_phones"]').val())) { field_phones_m_ru = 1; _sr('input[name="field_phones"]').css('border-color','red'); } else { field_phones_m_ru = 0; _sr('input[name="field_phones"]').css('border-color',border_color); } }
        if(_sr('input[name="field_company"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('ru')) { if(!ruReg.test(_sr('input[name="field_company"]').val())) { field_company_m_ru = 1; _sr('input[name="field_phones"]').css('border-color','red'); } else { field_company_m_ru = 0; _sr('input[name="field_company"]').css('border-color',border_color); } }
        if(field_name_first_m_ru == 0 && field_name_last_m_ru == 0 && field_name_mid_m_ru == 0 && field_city_m_ru == 0 && field_address_m_ru == 0 && field_phones_m_ru == 0 && field_company_m_ru == 0) { all_fields_m_ru = 0; } else { all_fields_m_ru = 1; }
        var field_name_first_m_latin = 0; var field_name_last_m_latin = 0; var field_name_mid_m_latin = 0; var field_city_m_latin = 0; var field_address_m_latin = 0; var field_phones_m_latin = 0; var field_company_m_latin = 0;
        if(_sr('input[name="field_name_first"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('latin')) { if(!enReg.test(_sr('input[name="field_name_first"]').val())) { field_name_first_m_latin = 1; _sr('input[name="field_name_first"]').css('border-color','red'); } else { field_name_first_m_latin = 0; _sr('input[name="field_name_first"]').css('border-color',border_color); } }
        if(_sr('input[name="field_name_last"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('latin')) { if(!enReg.test(_sr('input[name="field_name_last"]').val())) { field_name_last_m_latin = 1; _sr('input[name="field_name_last"]').css('border-color','red'); } else { field_name_last_m_latin = 0; _sr('input[name="field_name_last"]').css('border-color',border_color); } }
        if(_sr('input[name="field_name_mid"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('latin')) { if(!enReg.test(_sr('input[name="field_name_mid"]').val())) { field_name_mid_m_latin = 1; _sr('input[name="field_name_mid"]').css('border-color','red'); } else { field_name_mid_m_latin = 0; _sr('input[name="field_name_mid"]').css('border-color',border_color); } }
        if(_sr('input[name="field_city"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('latin')) { if(!enReg.test(_sr('input[name="field_city"]').val())) { field_city_m_latin = 1; _sr('input[name="field_city"]').css('border-color','red'); } else { field_city_m_latin = 0; _sr('input[name="field_city"]').css('border-color',border_color); } }
        if(_sr('input[name="field_address"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('latin')) { if(!enReg.test(_sr('input[name="field_address"]').val())) { field_address_m_latin = 1; _sr('input[name="field_address"]').css('border-color','red'); } else { field_address_m_latin = 0; _sr('input[name="field_address"]').css('border-color',border_color); } }
        if(_sr('input[name="field_phones"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('latin')) { if(!enReg.test(_sr('input[name="field_phones"]').val())) { field_phones_m_latin = 1; _sr('input[name="field_phones"]').css('border-color','red'); } else { field_phones_m_latin = 0; _sr('input[name="field_phones"]').css('border-color',border_color); } }
        if(_sr('input[name="field_company"]').hasClass('sr-required') && _sr('input[name="field_name_first"]').hasClass('latin')) { if(!enReg.test(_sr('input[name="field_company"]').val())) { field_company_m_latin = 1; _sr('input[name="field_phones"]').css('border-color','red'); } else { field_company_m_latin = 0; _sr('input[name="field_company"]').css('border-color',border_color); } }
        if(field_name_first_m_latin == 0 && field_name_last_m_latin == 0 && field_name_mid_m_latin == 0 && field_city_m_latin == 0 && field_address_m_latin == 0 && field_phones_m_latin == 0 && field_company_m_latin == 0) { all_fields_m_latin = 0; } else { all_fields_m_latin = 1; }
        if(all_fields_e == 0 && field_email_w == 0 && all_fields_m_ru == 0 && all_fields_m_latin == 0) {
            if(_sr('input[name="for_openType"]').length == 1) {
                event.preventDefault();
                var field_name_first = _sr('input[name="field_name_first"]').val();
                var field_email = _sr('input[name="field_email"]').val();
                var field_birth_day = _sr('#field_birth_li #day').val();
                var field_birth_month = _sr('#field_birth_li #month').val();
                var field_birth_year = _sr('#field_birth_li #year').val();
                var field_name_last = _sr('input[name="field_name_last"]').val();
                var field_name_mid = _sr('input[name="field_name_mid"]').val();
                var field_sex = _sr('input[name="field_sex"]').val();
                var field_charset_code = _sr('input[name="field_charset_code"]').val();
                var field_country_id = _sr('input[name="field_country_id"]').val();
                var field_city = _sr('input[name="field_city"]').val();
                var field_address = _sr('input[name="field_address"]').val();
                var field_phones = _sr('input[name="field_phones"]').val();
                var field_company = _sr('input[name="field_company"]').val();
                var uid = _sr('input[name="uid"]').val();
                var tid = _sr('input[name="tid"]').val();
                var did = _sr('input[name^="did"]').val();
                var remote_charset = 'UTF-8';
                var link = "https://smartresponder.ru/subscribe_rpc.html?field_name_first="+field_name_first+"&field_email="+field_email+"&field_birth_day="+field_birth_day+"&field_birth_month="+field_birth_month+"&field_birth_year="+field_birth_year+"&field_name_last="+field_name_last+"&field_name_mid="+field_name_mid+"&field_sex="+field_sex+"&field_charset_code="+field_charset_code+"&field_country_id="+field_country_id+"&field_city="+field_city+"&field_address="+field_address+"&field_phones="+field_phones+"&field_company="+field_company+"&uid="+uid+"&tid="+tid+"&did%5B%5D="+did+"&remote_charset=UTF-8";
                function str_replace(search, replace, subject) {
                    return subject.split(search).join(replace);
                }
                link = str_replace('undefined', '', link);
                _sr.ajax({
                    dataType: 'jsonp',
                    url: link,
                    jsonpCallback: 'callback',
                    success: function(json) {
                        if(json.status == 'success') {
                            alert(json.message);
                        }
                        else {
                            alert(json.message);
                        }
                    },
                    error: function() {
                        alert('Ошибка');
                    }
                });
            }
            else {
                return true;
            }
        } else { var error_message = ''; if(all_fields_e == 1) { error_message += 'Заполните обязательные поля.\n'; } if(field_email_w == 1) { error_message += 'Введите правильный Email адрес.\n'; } if(all_fields_m_ru == 1) { error_message += 'Буквы только русского алфавита!\n'; } if(all_fields_m_latin == 1) { error_message += 'Буквы только латинского алфавита!\n'; } alert(error_message); return false; }
    });
});