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
                        inputs = {};
                    if (objects === true) {
                        queryInputs.forEach(function (e, i) {
                            var name;
                            if (name = e.getAttribute('name')) {
                                inputs[name] = e;
                            }
                        });
                    } else {

                    }
                    return inputs;
                },
                bindForm: function (form) { // привязка событий (и условия событий)
                    inputs = this.serializeForm(form, true);
                    for (key in inputs) {
                        switch (key) {
                            case 'phone':
                                var matrix = "+7 ___ ___-__-__";

                                inputs[key].addEventListener("keyup", function (e) {
                                    helper.mask(e, this, matrix);
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
                                // var pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/g;
                                // inputs[key].addEventListener("keyup", function (e) {
                                //     this.value = this.value.replace(pattern, "");
                                // });
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
                                        this.value = this.value.replace(/[^A-Za-z -]/g, '');
                                    } else {
                                        app.data.editedFirstName = false;
                                    }
                                });
                                break;

                            case 'last-name_lat':
                                inputs[key].addEventListener("keyup", function (e) {
                                    if (this.value) {
                                        app.data.editedLastName = true;
                                        this.value = this.value.replace(/[^A-Za-z -]/g, '');
                                    } else {
                                        app.data.editedLastName = false;
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