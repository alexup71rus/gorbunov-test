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
                }
            },
            app = {
                data: {

                },
                init: function () {
                    this.bindForm(document.querySelector('#form'));
                },
                serializeForm: function (form, objects = false) {
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

                    if (Number.isInteger(event.key)) {
                        app.setCursorPosition(element.value.length, element);
                    }

                    return element.value;
                },
                bindForm: function (form) {
                    inputs = this.serializeForm(form, true);
                    for (key in inputs) {
                        switch (key) {
                            case 'phone':
                                var matrix = "+7 ___ ___-__-__";

                                inputs[key].addEventListener("keyup", function (e) {
                                    app.mask(e, this, matrix);
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
                        }
                        console.log(key);
                    }
                },
                validForm: function (form) {
                    var inputs = form.querySelectorAll('input');
                },
            };

        app.init();
    } catch (e) {
        console.error(e);
    }
})();