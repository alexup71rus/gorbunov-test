(function() {
    try {
        var helper = {
                translit: function ( str ) {
                    var ru = {
                        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
                        'е': 'e', 'ё': 'e', 'ж': 'j', 'з': 'z', 'и': 'i',
                        'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
                        'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
                        'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh',
                        'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'u', 'я': 'ya'
                    }, n_str = [];

                    str = str.replace(/[ъь]+/g, '').replace(/й/g, 'i');

                    for ( var i = 0; i < str.length; ++i ) {
                        n_str.push(
                            ru[ str[i] ]
                            || ru[ str[i].toLowerCase() ] == undefined && str[i]
                            || ru[ str[i].toLowerCase() ].replace(/^(.)/, function ( match ) { return match.toUpperCase() })
                        );
                    }

                    return n_str.join('');
                },
                setCursorPosition: function(pos, elem) {
                    elem.focus();
                    if (elem.setSelectionRange) elem.setSelectionRange(pos, pos);
                    else if (elem.createTextRange) {
                        var range = elem.createTextRange();
                        range.collapse(true);
                        range.moveEnd("character", pos);
                        range.moveStart("character", pos);
                        range.select()
                    }
                },
                mask: function(event, element, matrix) {
                    var i = 0,
                        def = matrix.replace(/\D/g, ""),
                        val = element.value.replace(/\D/g, "");

                    if (def.length >= val.length) val = def;

                    element.value = matrix.replace(/./g, function(a) {
                        return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? "" : a
                    });

                    if (Number.isInteger(+event.key)) { // для поддержки браузеров
                        this.setCursorPosition(element.value.length, element);
                    }

                    return element.value;
                },
            },
            app = {
                data: {
                    editedLastName: false,
                    editedFirstName: false,
                },
                init: function () {
                    this.bindForm(document.querySelector('#form'));
                },
                serializeForm: function (form, objects = false) { // сереализовать форму в объект или в массив имён
                    var queryInputs = form.querySelectorAll('input'),
                        querySelects = form.querySelectorAll('select'),
                        eachAll = [queryInputs, querySelects];

                        inputs = {};
                    if (objects === true) {
                        eachAll.forEach(function (e, i) {
                            e.forEach(function (e, i) {
                                var name;
                                if (name = e.getAttribute('name')) {
                                    inputs[name] = e;
                                }
                            });
                        });
                    } else {

                    }
                    return inputs;
                },
                bindError: function (elem, pattern, isregexp, text) {
                    var elItem = elem.closest(".js-form__item");
                    var elError = elItem.querySelector(".js-field-error");
                    var valid = false;
                    if (elItem && elError && text) {
                        if (isregexp) {
                            valid = pattern.test(elem.value);
                        } else {
                            valid = pattern;
                        }
                        if (valid) {
                            elItem.classList.add('js-error');
                            elError.innerText = text;
                        } else {
                            elItem.classList.remove('js-error');
                            elError.innerText = '';
                        }
                        return true;
                    } else {
                        return false;
                    }
                },
                bindForm: function (form) { // привязка событий (и условия событий)
                    inputs = this.serializeForm(form, true);
                    for (key in inputs) {
                        switch (key) {
                            case 'phone':
                                var matrix = "+7 ___ ___-__-__";

                                inputs[key].addEventListener("keyup", function (e) {
                                    helper.mask(e, this, matrix);

                                    if (this.value.length > 16) {
                                        app.bindError(this, true, false, 'Только цифры, до 16 символов');
                                    }
                                });

                                inputs[key].addEventListener("click", function () {
                                    if (!this.value) {
                                        this.value = '+7 ';
                                    }
                                });
                                inputs[key].addEventListener("blur", function () {
                                    if (this.value === '+7 ' || this.value === '+7') {
                                        this.value = '';
                                    }
                                });
                                break;

                            case 'email':
                                inputs[key].addEventListener("keyup", function (e) {
                                    if (this.value.length > 0) {
                                        app.bindError(this, !/(.*(@).+)/g.test(this.value), false, 'Не сможем связаться по этому адресу');
                                    } else {
                                        console.log(this.value);
                                        app.bindError(this, false, false, '.');
                                    }
                                });
                                break;

                            case 'first-name':
                                inputs[key].addEventListener("keyup", function (e) {
                                    if (app.data.editedFirstName === false) {
                                        inputs['first-name_lat'].value = helper.translit(this.value);
                                    }
                                });
                                break;

                            case 'last-name':
                                inputs[key].addEventListener("keyup", function (e) {
                                    if (app.data.editedLastName === false) {
                                        inputs['last-name_lat'].value = helper.translit(this.value);
                                    }
                                });
                                break;

                            case 'first-name_lat':
                                inputs[key].addEventListener("keyup", function (e) {
                                    if (this.value) {
                                        app.data.editedFirstName = true;
                                        if (this.value.length > 25) {
                                            app.bindError(this, true, false, 'Вы превысили максимальное значение поля в 25 символов');
                                        } else {
                                            app.bindError(this, /[^A-Za-z -]/g, true, 'Допускается ввод только латиницей');
                                        }
                                    } else {
                                        app.data.editedFirstName = false;
                                    }
                                });
                                break;

                            case 'last-name_lat':
                                window.ln = inputs[key];
                                inputs[key].addEventListener("keyup", function (e) {
                                    if (this.value) {
                                        app.data.editedLastName = true;
                                        if (this.value.length > 25) {
                                            app.bindError(this, true, false, 'Вы превысили максимальное значение поля в 25 символов');
                                        } else {
                                            app.bindError(this, /[^A-Za-z -]/g, true, 'Допускается ввод только латиницей');
                                        }
                                    } else {
                                        app.data.editedLastName = false;
                                    }
                                });
                                break;

                            case 'birthdate-months':
                            case 'birthdate-years':
                                inputs[key].addEventListener("change", function (e) {
                                    var days = 32 - new Date(inputs['birthdate-years'].value, inputs['birthdate-months'].value, 32).getDate(),
                                        itemsHTML = '';

                                    for (var day = 1; day < days; day++) {
                                        itemsHTML += '<option value="'+day+'">'+day+'</option>';
                                    }

                                    inputs['birthdate-days'].innerHTML = itemsHTML;

                                });
                                break;

                            case 'gender':
                                console.log(inputs[key])
                                inputs[key].closest('.js-gender').classList.add('hidden');
                                break;

                            case 'sure-name':
                                inputs[key].addEventListener("blur", function (e) {
                                    if (inputs['gender'].value !== 'undefined') {
                                        inputs['gender'].closest('.js-gender').classList.add('hidden');
                                    } else {
                                        inputs['gender'].closest('.js-gender').classList.remove('hidden');
                                    }
                                });
                                inputs[key].addEventListener("keyup", function (e) {
                                    var value = this.value.trim(),
                                        genderTable = { // будет браться с сервера
                                            'ич': 'male',
                                            'на': 'female',
                                            'лы': 'male',
                                            'зы': 'female',
                                            'ва': 'female',
                                        },
                                        sp = {
                                            'male': [
                                                'Женат',
                                                'Разведён',
                                                'Холост',
                                                'Вдовец',
                                            ],
                                            'female': [
                                                'Замужем',
                                                'Разведена',
                                                'Не замужем',
                                                'Вдова',
                                            ],
                                            'for_all': [
                                                'В «гражданском браке»'
                                            ]
                                        },
                                        itemsHTML = '';

                                    if (value.length > 2) {
                                        var genderVal = genderTable[ this.value.substr(this.value.length-2, this.value.length).toLowerCase() ];
                                        if (genderVal) {
                                            for (gender in sp) {
                                                if (gender === genderVal || gender === 'for_all') {
                                                    for (item in sp[gender]) {
                                                        itemsHTML += '<option value="'+sp[gender][item]+'">'+sp[gender][item]+'</option>';
                                                    }
                                                }
                                            }

                                            inputs['marital-status'].innerHTML = itemsHTML;
                                        }
                                        inputs['gender'].value = genderVal;
                                    }
                                });
                                break;
                        }
                    }
                },
                validForm: function (form) { //
                    var inputs = form.querySelectorAll('input');
                },
            };

        app.init();
    } catch (e) {
        console.error(e);
    }
})();