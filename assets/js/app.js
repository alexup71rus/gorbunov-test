(function() {
    'use strict';
    try {
        var helper = {
                /*
                * Транслит русского текста на английский
                */
                translit: function ( str ) {
                    var ru = window.arTranslit, n_str = [];

                    str = str.replace(/[ь]+/g, '').replace(/й/g, 'i');

                    for ( var i = 0; i < str.length; ++i ) {
                        n_str.push(
                            ru[ str[i] ]
                            || ru[ str[i].toLowerCase() ] == undefined && str[i]
                            || ru[ str[i].toLowerCase() ].replace(/^(.)/, function ( match ) { return match.toUpperCase() })
                        );
                    }

                    return n_str.join('');
                },
                /*
                * Установить позицию курсора в поле
                */
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
                /*
                * Установить маску на поле
                */
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
                typewriter: function (objs, str) {
                    objs.forEach(function (obj) {
                        var countStr = 0,
                            keyInterval,
                            height = obj.offsetHeight;
                        obj.textContent = '';
                        obj.style.display = 'block';
                        obj.style.height = height + 'px';
                        keyInterval = setInterval(function () {
                            if (obj.textContent.length < str.length) {
                                obj.textContent = str.substr(0, countStr+1) + '|';
                                countStr++;
                            } else {
                                obj.textContent = str.substr(0, countStr+1);
                                obj.style.height = 'auto';
                                clearInterval(keyInterval);
                            }

                        }, 100);
                    });
                },
            },
            app = {
                data: {
                    invalidFields: [],
                    editedLastName: false,
                    editedFirstName: false,
                    gender: 'male',
                },
                init: function () { // старт программы
                    this.data.inputs = this.serializeForm(form, true);

                    form.addEventListener("submit", function (e) {
                        e.preventDefault();
                        app.validateForm();
                    });

                    form.addEventListener("click", app.bindOnChange), form.addEventListener("keyup", app.bindOnChange);

                    this.restoreForm();
                    this.saveForm();
                    helper.typewriter(
                        document.querySelectorAll('.typewriter'),
                        'Эффективный диаметр жизненно вызывает случайный эффективный радиус, а время ожидания ответа составило бы 80 миллиардов лет.'
                    );

                    this.bindForm(document.querySelector('#form'));
                },
                serializeForm: function (form, objects = false) { // сереализовать форму в объект или в массив имён
                    var queryText = form.querySelectorAll('input'),
                        queryCheckbox = form.querySelectorAll('input[type="checkbox"]'),
                        queryRadio = form.querySelectorAll('input[type="radio"]:checked'),
                        querySelects = form.querySelectorAll('select'),
                        eachAll = [queryText, queryCheckbox, queryRadio, querySelects],
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
                        inputs = eachAll;
                    }
                    return inputs;
                },
                /*
                * Поках ошибок
                */
                showError: function (elem, arValidFields = {}) {
                    var elItem = elem.closest(".js-form__item"),
                        elError,
                        wrong = false;

                    if (elItem) {
                        elError = elItem.querySelector(".js-field-error")
                    }

                    if (elItem && elError && arValidFields) {
                        for (var item in arValidFields) {
                            if (arValidFields[item].result === true) {
                                wrong = arValidFields[item].text;
                            }
                        }

                        if (wrong) {
                            elem.classList.add('js-wrong');
                            elItem.classList.add('js-error');
                            elError.innerText = wrong;
                            app.data.invalidFields[elem.getAttribute('name')] = false;
                            return false;
                        } else {
                            elem.classList.remove('js-wrong');
                            elItem.classList.remove('js-error');
                            elError.innerText = '';
                            delete app.data.invalidFields[elem.getAttribute('name')];
                            return true;
                        }
                        return true;
                    } else {
                        return false;
                    }
                },
                bindOnChange: async function (form) {
                    var allInputsValid = true;

                    if (Object.keys(app.data.invalidFields).length) {
                        allInputsValid = false;
                    } else {
                        for (var input in app.data.inputs) {
                            if (app.data.inputs[input].value.length === 0 && app.data.inputs[input].required) {
                                allInputsValid = false;
                            }
                        }
                    }

                    if (allInputsValid === true) {
                        document.querySelector('.js-form__item__submit').classList.remove('js-submit-disibled');
                    } else {
                        document.querySelector('.js-form__item__submit').classList.add('js-submit-disibled');
                    }

                    app.saveForm();
                },
                /*
                * привязка событий (и условия событий, не стал выносить)
                */
                bindForm: function (form) {
                    for (var key in this.data.inputs) {
                        switch (key) {
                            case 'phone':
                                var matrix = "+7 ___ ___-__-__";

                                this.data.inputs[key].addEventListener("keyup", function (e) {
                                    helper.mask(e, this, matrix);
                                });

                                this.data.inputs[key].addEventListener("click", function () {
                                    if (!this.value) {
                                        this.value = '+7 ';
                                    }
                                });
                                this.data.inputs[key].addEventListener("blur", function () {
                                    if (this.value === '+7 ' || this.value === '+7') {
                                        this.value = '';
                                        app.showError(this, [
                                            {
                                                result: false,
                                            },
                                        ]);
                                    } else if (this.value.length < 16) {
                                        app.showError(this, [
                                            {
                                                result: ( (this.value.length > 0) && !/(.*(@).+)/g.test(this.value.normalize('NFC'))),
                                                text: 'Только цифры, до 16 символов'
                                            },
                                        ]);
                                    } else if (this.value.length === 16) {
                                        app.showError(this, [
                                            {
                                                result: false,
                                            },
                                        ]);
                                    }
                                });
                                break;

                            case 'email':
                                this.data.inputs[key].addEventListener("blur", function (e) {
                                    app.showError(this, [
                                        {
                                            result: ( (this.value.length > 0) && !/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/g.test(this.value.toLowerCase().normalize('NFC'))),
                                            text: 'Не сможем связаться по этому адресу'
                                        },
                                    ]);
                                });
                                break;

                            case 'first-name':
                                this.data.inputs[key].addEventListener("keyup", function (e) {
                                    if (app.data.editedFirstName === false) {
                                        app.data.inputs['first-name_lat'].value = helper.translit(this.value.normalize('NFC'));
                                    }
                                    app.showError(this, [
                                        {
                                            result: /[^А-ЯЁа-яё -]/.test(this.value),
                                            text: 'Допускается ввод кириллицей, дефис и пробел'
                                        },
                                        {
                                            result: (this.value.length > 20),
                                            text: 'Вы превысили максимальное значение поля в 20 символов'
                                        },
                                    ]);
                                });
                                break;

                            case 'last-name':
                                this.data.inputs[key].addEventListener("keyup", function (e) {
                                    if (app.data.editedLastName === false) {
                                        app.data.inputs['last-name_lat'].value = helper.translit(this.value.normalize('NFC'));
                                    }
                                    app.showError(this, [
                                        {
                                            result: /[^А-ЯЁа-яё -]/.test(this.value.normalize('NFC')),
                                            text: 'Допускается ввод кириллицей, дефис и пробел'
                                        },
                                        {
                                            result: (this.value.length > 20),
                                            text: 'Вы превысили максимальное значение поля в 20 символов'
                                        },
                                    ]);
                                });
                                break;

                            case 'old-last-name':
                                this.data.inputs[key].addEventListener("keyup", function (e) {
                                    app.showError(this, [
                                        {
                                            result: /[^А-ЯЁа-яё -]/.test(this.value.normalize('NFC')),
                                            text: 'Допускается ввод кириллицей, дефис и пробел'
                                        },
                                        {
                                            result: (this.value.length > 20),
                                            text: 'Вы превысили максимальное значение поля в 20 символов'
                                        },
                                    ]);
                                });
                                break;


                            case 'first-name_lat':
                                this.data.inputs[key].addEventListener("keyup", function (e) {
                                    if (this.value) {
                                        app.data.editedFirstName = true;
                                    } else {
                                        app.data.editedFirstName = false;
                                    }

                                    app.showError(this, [
                                        {
                                            result: (this.value.length > 25),
                                            text: 'Вы превысили максимальное значение поля в 25 символов'
                                        },
                                        {
                                            result: ( (this.value.length > 0) && /[^A-Za-z -]/g.test(this.value.normalize('NFC'))),
                                            text: 'Допускается ввод только латиницей'
                                        },
                                    ]);
                                });
                                break;

                            case 'last-name_lat':
                                this.data.inputs[key].addEventListener("keyup", function (e) {
                                    if (this.value) {
                                        app.data.editedLastName = true;
                                        app.showError(this, [
                                            {
                                                result: (this.value.length > 25),
                                                text: 'Вы превысили максимальное значение поля в 25 символов'
                                            },
                                            {
                                                result: ( (this.value.length > 0) && /[^A-Za-z -]/g.test(this.value.normalize('NFC'))),
                                                text: 'Допускается ввод только латиницей'
                                            },
                                        ]);
                                    } else {
                                        app.data.editedLastName = false;
                                    }
                                });
                                break;

                            case 'birthdate-days':
                                // app.showError(this, [
                                //     {
                                //         result: (!app.data.inputs['birthdate-days'].value),
                                //         text: 'Поле не заполнено'
                                //     },
                                // ]);
                                break;

                            case 'birthdate-months':
                            case 'birthdate-years':
                                this.data.inputs[key].addEventListener("change", function (e) {
                                    var days = 32 - new Date(app.data.inputs['birthdate-years'].value, app.data.inputs['birthdate-months'].value, 32).getDate(),
                                        itemsHTML = '',
                                        selectedId = app.data.inputs['birthdate-days'].value,
                                        selected = '';

                                    if (days < selectedId) {
                                        selectedId = days;
                                    }

                                    for (var day = 1; day <= days; day++) {
                                        if (day == selectedId) {
                                            selected = 'selected';
                                        } else {
                                            selected = '';
                                        }

                                        if (day < 10) {
                                            day = '0' + day;
                                        }

                                        itemsHTML += '<option value="'+day+'" '+selected+'>'+day+'</option>';
                                    }

                                    app.data.inputs['birthdate-days'].innerHTML = itemsHTML;

                                    app.showError(app.data.inputs['birthdate-months'], [
                                        {
                                            result: false, // (!app.data.inputs['birthdate-months'].value),
                                            text: 'Поле не заполнено'
                                        },
                                    ]);

                                    app.showError(app.data.inputs['birthdate-years'], [
                                        {
                                            result: false, //  (!app.data.inputs['birthdate-years'].value)
                                            text: 'Поле не заполнено'
                                        },
                                    ]);

                                });
                                break;

                            case 'marital-status':
                                this.data.inputs[key].addEventListener("change", function (e) {
                                    app.showError(this, [
                                        {
                                            result: (!app.data.inputs['marital-status'].value), //  (!app.data.inputs['marital-status'].value),
                                            text: 'Поле не заполнено'
                                        },
                                    ]);
                                });
                                break;

                            case 'education':
                                this.data.inputs[key].addEventListener("change", function (e) {
                                    app.showError(this, [
                                        {
                                            result: (!app.data.inputs['education'].value),
                                            text: 'Поле не заполнено'
                                        },
                                    ]);
                                });
                                break;

                            case 'gender':
                                if (this.data.inputs[key].closest('.js-gender.hiddenstart')) {
                                    this.data.inputs[key].closest('.js-gender.hiddenstart').classList.add('hidden');
                                }
                                document.querySelectorAll('[name="gender"]').forEach(function (el) {
                                    el.addEventListener("click", function (e) {
                                        app.data.gender = this.value;
                                        app.changeGender(this.value);
                                    });
                                });
                                break;

                            case 'patronymic':
                                this.data.inputs[key].addEventListener("blur", function (e) {
                                    if (app.data.gender) {
                                        app.data.inputs['gender'].closest('.js-gender').classList.add('hidden');
                                    } else {
                                        app.data.inputs['gender'].closest('.js-gender').classList.remove('hidden');
                                    }
                                });
                                this.data.inputs[key].addEventListener("keyup", function (e) {
                                    var value = this.value.trim(),
                                        genderTable = window.arGenderTable;

                                    app.showError(this, [
                                        {
                                            result: (this.value.length > 25),
                                            text: 'Вы превысили максимальное значение поля в 25 символов'
                                        },
                                        {
                                            result: ( (this.value.length > 0) && /[^А-ЯЁа-яё -]/.test(this.value)),
                                            text: 'Допускается ввод только латиницей'
                                        },
                                    ]);

                                    if (value.length > 2) {
                                        var genderVal = genderTable[ this.value.substr(this.value.length-2, this.value.length).toLowerCase() ];
                                        if (genderVal) {
                                            app.changeGender(genderVal);
                                        }
                                        app.data.gender = genderVal;
                                    }
                                });
                                break;
                        }
                    }
                },
                saveForm: async function (clear) {
                    var data = {};

                    app.data.inputs = app.serializeForm(form, true);

                    for (var input in app.data.inputs) {
                        if (clear === true) {
                            app.data.inputs[input].value = '';
                        }
                        data[input] = app.data.inputs[input].value;
                    }

                    localStorage.setItem('fields', JSON.stringify(data));
                },
                restoreForm: async function () {
                    var fieldsJson = localStorage.getItem('fields'),
                        fields = {};
                    try {
                        fields = JSON.parse(fieldsJson);
                    } catch (e) {
                        console.log('Вы зашли на эту страницу впервые?');
                    }

                    for (var input in app.data.inputs) {
                        if (fields && typeof fields[input] !== "undefined") {
                            switch (input) {
                                case 'last-name':
                                case 'first-name':
                                case 'patronymic':
                                case 'last-name_lat':
                                case 'first-name_lat':
                                case 'phone':
                                case 'email':
                                case 'birthdate-days':
                                case 'birthdate-months':
                                case 'birthdate-years':
                                case 'marital-status':
                                case 'education':
                                    if (fields[input].length) {
                                        app.data.inputs[input].value = fields[input];
                                    }
                                    break;

                                case 'gender':
                                    if (fields[input]) {
                                        document.querySelector('[name="gender"][value="'+fields[input]+'"]').click();
                                        if (app.data.gender) {
                                            app.data.inputs['gender'].closest('.js-gender').classList.add('hidden');
                                        } else {
                                            app.data.inputs['gender'].closest('.js-gender').classList.remove('hidden');
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                },
                validateForm: function () {
                    var inputs = app.data.inputs,
                        XHR,
                        data = {},
                        dataStr = '',
                        inputsJson;

                    data['ajax'] = 'Y';
                    dataStr = 'ajax=Y';

                    for (var input in inputs) {
                        data[input] = inputs[input].value;
                        dataStr += '&' + input + '=' + encodeURIComponent(inputs[input].value)
                    }

                    if ("onload" in new XMLHttpRequest()) {
                        XHR = XMLHttpRequest;
                    } else {
                        XHR = XDomainRequest;
                    }

                    var connection = new XHR();

                    connection.open('GET', '/?'+dataStr);

                    connection.onload = function() {
                        var resInputs = JSON.parse(this.responseText);

                        if (resInputs && resInputs.code >= 0) {
                            if (resInputs.code === 23000) {
                                document.querySelector('#error-exeption').innerText = resInputs.message;
                                document.querySelector('.js-form__item__content-footer').classList.add('js-error');
                            } else if (resInputs.code === 0) {
                            } else if (resInputs.code === 2) {
                                document.querySelector('.js-form__item__content-footer').classList.add('hidden');
                                document.querySelector('.js-form__item__content-footer_success').classList.remove('hidden');
                                document.querySelector('#error-exeption').innerText = '';
                                document.querySelector('.js-form__item__content-footer').classList.remove('js-error');
                                app.saveForm(true);
                                for (var input in app.data.inputs) {
                                    app.data.inputs[input].disabled = true;
                                    console.log(app.data.inputs[input]);
                                }
                                document.querySelector('[name="gender"]').disabled = true;
                                document.querySelector('#form-item-cln-chk').disabled = true;

                            } else {
                                document.querySelector('#error-exeption').innerText = resInputs.message;
                                document.querySelector('.js-form__item__content-footer').classList.add('js-error');
                                console.error('code ' + resInputs.code, resInputs.message);
                            }




                            for (input in resInputs.body) {
                                var inputElem = document.querySelector('[name="'+input+'"]');

                                app.showError(inputElem, [
                                    {
                                        result: resInputs.body[input].error,
                                        text: resInputs.body[input].text_error
                                    }
                                ]);
                            }
                        } else {
                            document.querySelector('#error-exeption').innerText = 'От сервера пришли неверные данные';
                            document.querySelector('.js-form__item__content-footer').classList.add('js-error');
                        }
                    }

                    connection.onerror = function() {
                        console.error(this.status);
                        document.querySelector('#error-exeption').innerText = this.status;
                        document.querySelector('.js-form__item__content-footer').classList.add('js-error');
                    }

                    connection.send();
                },
                changeGender: function (genderVal) {
                    var sp = window.arSP,
                        itemsHTML = '',
                        elementRadio = document.querySelector('input[type="radio"][value="'+genderVal+'"]');

                    if (elementRadio) {
                        elementRadio.checked = true;
                    }

                    for (var gender in sp) {
                        if (gender === genderVal || gender === 'for_all') {
                            for (var item in sp[gender]) {
                                itemsHTML += '<option value="'+sp[gender][item]+'">'+sp[gender][item]+'</option>';
                            }
                        }
                    }

                    app.data.inputs['marital-status'].innerHTML = itemsHTML;
                },
            };

        app.init();
    } catch (e) {
        console.error(e);
    }
})();