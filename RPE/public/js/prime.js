
[].forEach.call(document.getElementsByClassName('tags_input'), function (el) {
    let hiddenInput = document.createElement('input'),
        mainInput = document.createElement('input'),
        tags = [];



    //mainInput.setAttribute('placeholder', 'IDs de Natureza de Atividade');
  

    mainInput.setAttribute('id', 'input_natureza');

    //hiddenInput.setAttribute = ("required","");
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('id', 'hidden_naturezas');
    hiddenInput.setAttribute('name', el.getAttribute('data-name'));
    //hiddenInput.setAttribute('value', el.oldValue);

    mainInput.setAttribute('type', 'text');
    mainInput.classList.add('main-input');


    /*mainInput.addEventListener('input', function () {
        let enteredTags = mainInput.value.split("\n");
        if (enteredTags.length > 1) {
            enteredTags.forEach(function (t) {
                let filteredTag = filterTag(t);
                if (filteredTag.length > 0 ){
                    if(!(hiddenInput.value.includes(filteredTag))){
                        addTag(filteredTag);
                        
                    }else{
                        alert('Nao pode haver IDs repetidos');
                        //removeTag(hiddenInput.value.indexOf(filteredTag));
                        delete(filteredTag);
                    }
                }

            });
            
            mainInput.value = '';
            
        }
        
    });*/


    mainInput.addEventListener('keydown',function(e){
        let enteredTags = [];
        if (e.keyCode === 13) {
            
            enteredTags = mainInput.value;
            var json_data;
            let id_n = [];
            
            var aux_j = 0;
            $.getJSON("http://192.168.3.1/storage/natureza.json", function(json) {
                json_data = json;
                

                //console.log(aux_j)

                let enteredTags_ = [];
                let k = 0;
                let aux = '';
                for (let i = 0; i < enteredTags.length; i++) {
                if (enteredTags[i] != ",") {
                        aux = aux + enteredTags[i];
                        enteredTags_[k] = aux;
                    
                }else{
                        k++;
                        aux = '';
                }
                    
                }

                //console.log(enteredTags_)

                if (enteredTags_.length > 0 ) {
                    enteredTags_.forEach(function(t){
                        let filteredTag = filterTag(t);
                        var aux_j = 0;
                        for(var i in json_data){
                            //console.log(json_data [i])
                            if (filteredTag == json_data [i]) {
                                aux_j++;
                            }
                            //console.log(aux)
                        }
                        if (aux_j == 0) {
                            alert('ID inserido não existe!!');
                            delete(filteredTag);
                        }else{
                            if(!(hiddenInput.value.includes(filteredTag))){
                                addTag(filteredTag);
                                
                            }else{
                                alert('Nao pode haver IDs repetidos');
                                delete(filteredTag);
                            }
                        }



                    })

                    mainInput.value = '';
                }
                
                 // this will show the info it in firebug console
            });



        }

       
    })

    

    mainInput.addEventListener('keydown', function (e) {
        let keyCode = e.which || e.keyCode;
        if (keyCode === 8 && mainInput.value.length === 0 && tags.length > 0) {
            removeTag(tags.length - 1);
        }
    });

    el.appendChild(mainInput);
    el.appendChild(hiddenInput);

    

    function addTag (text) {
        let tag = {
            text: text,
            element: document.createElement('span'),
        };

        tag.element.classList.add('tag');
        tag.element.textContent = tag.text;



        let closeBtn = document.createElement('span');

        closeBtn.classList.add('close');
        closeBtn.addEventListener('click', function () {
            removeTag(tags.indexOf(tag));
        });
        tag.element.appendChild(closeBtn);


 
        tags.push(tag);



        el.insertBefore(tag.element, mainInput);

        refreshTags();
        mainInput.setAttribute('value',hiddenInput.value);

    }

    function removeTag (index) {
        let tag = tags[index];
        tags.splice(index, 1);
        el.removeChild(tag.element);
        refreshTags();
    }

    function refreshTags () {
        let tagsList = [];
        tags.forEach(function (t) {
            tagsList.push(t.text);
        });
        hiddenInput.value = tagsList.join(',');
    }

    function filterTag (tag) {
        return tag.replace(/[^\w -]/g, '').trim().replace(/\W+/g, '-');
    }

    

});

[].forEach.call(document.getElementsByClassName('tags_area'), function (el) {
    let hiddenInput = document.createElement('input'),
        mainInput = document.createElement('input'),
        tags = [];

    //mainInput.setAttribute('placeholder', 'IDs de Areas de Atividade');
    mainInput.setAttribute('id', 'input_area');
    
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('id', 'hidden_area');
    hiddenInput.setAttribute('name', el.getAttribute('data-name'));

    mainInput.setAttribute('type', 'text');
    mainInput.classList.add('main-input');


    /*mainInput.addEventListener('input', function () {
        let enteredTags = mainInput.value.split(',');
        if (enteredTags.length > 1) {
            enteredTags.forEach(function (t) {
                let filteredTag = filterTag(t);
                if (filteredTag.length > 0 ){
                    if(!(hiddenInput.value.includes(filteredTag))){
                        addTag(filteredTag);
                    }else{
                        alert('Nao pode haver IDs repetidos');
                        //removeTag(hiddenInput.value.indexOf(filteredTag));
                        delete(filteredTag);
                    }
                }

            });
            mainInput.value = '';
        }
    });*/

    mainInput.addEventListener('keydown',function(e){
        let enteredTags = [];
        if (e.keyCode === 13) {
            
            enteredTags = mainInput.value;
            var aux_j = 0;
            var json_data;
            $.getJSON("http://192.168.3.1/storage/area.json", function(json) {
                //console.log(json)

                json_data = json;
                


                let enteredTags_ = [];
                let k = 0;
                let aux = '';
                for (let i = 0; i < enteredTags.length; i++) {
                   if (enteredTags[i] != ",") {
                        aux = aux + enteredTags[i];
                        enteredTags_[k] = aux;
                       
                   }else{
                        k++;
                        aux = '';
                   }
                    
                }
    
                //console.log(enteredTags_)
    
                if (enteredTags_.length > 0 ) {
                    enteredTags_.forEach(function(t){
                        let filteredTag = filterTag(t);
                        var aux_j = 0;
                        for(var i in json_data){
                            //console.log(json_data [i])
                            if (filteredTag == json_data [i]) {
                                aux_j++;
                            }
        
                            
                            //console.log(aux)
                        }
                        if (aux_j == 0) {
                            alert('ID inserido não existe!!');
                            delete(filteredTag);
                        }else{
                            if(!(hiddenInput.value.includes(filteredTag))){
                                addTag(filteredTag);
                                
                            }else{
                                alert('Nao pode haver IDs repetidos');
                                delete(filteredTag);
                            }
                        }

                    })
    
                    mainInput.value = '';
                }
    


            });



            /*if (enteredTags.length > 0) {
                //alert(enteredTags);
                console.log(enteredTags)
                enteredTags.forEach(function (t) {
                    let filteredTag = filterTag(t);
                    if (filteredTag.length > 0 ){
                        if(!(hiddenInput.value.includes(filteredTag))){
                            addTag(filteredTag);
                            
                        }else{
                            alert('Nao pode haver IDs repetidos');
                            //removeTag(hiddenInput.value.indexOf(filteredTag));
                            delete(filteredTag);
                        }
                    }
    
                });

                    let filteredTag = filterTag(enteredTags);
                    if (filteredTag.length > 0 ){
                        if(!(hiddenInput.value.includes(filteredTag))){
                            addTag(filteredTag);
                            
                        }else{
                            alert('Nao pode haver IDs repetidos');
                            //removeTag(hiddenInput.value.indexOf(filteredTag));
                            delete(filteredTag);
                        }
                    }
                
                mainInput.value = '';
                
            }*/
        }

       
    })

    mainInput.addEventListener('keydown', function (e) {
        let keyCode = e.which || e.keyCode;
        if (keyCode === 8 && mainInput.value.length === 0 && tags.length > 0) {
            removeTag(tags.length - 1);
        }
    });

    el.appendChild(mainInput);
    el.appendChild(hiddenInput);

    

    function addTag (text) {
        let tag = {
            text: text,
            element: document.createElement('span'),
        };

        tag.element.classList.add('tag');
        tag.element.textContent = tag.text;



        let closeBtn = document.createElement('span');

        closeBtn.classList.add('close');
        closeBtn.addEventListener('click', function () {
            removeTag(tags.indexOf(tag));
        });
        tag.element.appendChild(closeBtn);


 
        tags.push(tag);



        el.insertBefore(tag.element, mainInput);

        refreshTags();


    }

    function removeTag (index) {
        let tag = tags[index];
        tags.splice(index, 1);
        el.removeChild(tag.element);
        refreshTags();
    }

    function refreshTags () {
        let tagsList = [];
        tags.forEach(function (t) {
            tagsList.push(t.text);
        });
        hiddenInput.value = tagsList.join(',');
    }

    function filterTag (tag) {
        return tag.replace(/[^\w -]/g, '').trim().replace(/\W+/g, '-');
    }

});

[].forEach.call(document.getElementsByClassName('tags_participante'), function (el) {
    let hiddenInput = document.createElement('input'),
        mainInput = document.createElement('input'),
        tags = [];

    //mainInput.setAttribute('placeholder', 'Username dos Participantes da Atividade');
    mainInput.setAttribute('id', 'input_participantes');

    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', el.getAttribute('data-name'));
    hiddenInput.setAttribute('id','input_participantes_hiden')
    mainInput.setAttribute('type', 'text');
    mainInput.classList.add('main-input');
    
    mainInput.addEventListener('keydown',function(e){
        let enteredTags = [];
        if (e.keyCode === 13) {
            
            enteredTags = mainInput.value;
            //console.log(enteredTags)
            var aux_j = 0;
            var json_data;
            $.getJSON("http://192.168.3.1/storage/users.json", function(json) {
                //console.log(json)

                let enteredTags_ = [];
                let k = 0;
                let aux = '';
                for (let i = 0; i < enteredTags.length; i++) {
                   if (enteredTags[i] != ",") {
                        aux = aux + enteredTags[i];
                        enteredTags_[k] = aux;
                       
                   }else{
                        k++;
                        aux = '';
                   }
                    
                }
                
                json_data = json;
                //console.log(enteredTags_)
    
                if (enteredTags_.length > 0 ) {
                    enteredTags_.forEach(function(t){
                        let filteredTag = filterTag(t);
                        var aux_j = 0;
                        for(var i in json_data){
                            //console.log(json_data [i])
                            //console.log(t)
                            if (filteredTag == json_data [i]) {
                                
                                aux_j++;
                            }
        
                        }

                        if (aux_j == 0) {
                            alert('Usuario inserido não existe!!');
                            delete(filteredTag);
                        }else{
                            if(!(hiddenInput.value.includes(filteredTag))){
                                addTag(filteredTag);
                                
                            }else{
                                alert('Nao pode haver IDs repetidos');
                                delete(filteredTag);
                            }
                        }

                    })
    
                    mainInput.value = '';
                }
    


            });
            
            /*if (enteredTags.length > 0) {
                    let filteredTag = filterTag(enteredTags);
                    if (filteredTag.length > 0 ){
                        if(!(hiddenInput.value.includes(filteredTag))){
                            addTag(filteredTag);

                        }else{
                            alert('Nao pode haver IDs repetidos');
                            //removeTag(hiddenInput.value.indexOf(filteredTag));
                            delete(filteredTag);
                        }
                    }
                    mainInput.value = '';
                filterTag('');
                enteredTags.value = '';
            }*/

            
        }

       
    })

    mainInput.addEventListener('keydown', function (e) {
        let keyCode = e.which || e.keyCode;
        if (keyCode === 8 && mainInput.value.length === 0 && tags.length > 0) {
            removeTag(tags.length - 1);
        }
    });

    el.appendChild(mainInput);
    el.appendChild(hiddenInput);

    

    function addTag (text) {
        let tag = {
            text: text,
            element: document.createElement('span'),
        };

        tag.element.classList.add('tag');
        tag.element.textContent = tag.text;



        let closeBtn = document.createElement('span');

        closeBtn.classList.add('close');
        closeBtn.addEventListener('click', function () {
            removeTag(tags.indexOf(tag));
        });
        tag.element.appendChild(closeBtn);


 
        tags.push(tag);



        el.insertBefore(tag.element, mainInput);

        refreshTags();


    }

    function removeTag (index) {
        let tag = tags[index];
        tags.splice(index, 1);
        el.removeChild(tag.element);
        refreshTags();
    }

    function refreshTags () {
        let tagsList = [];
        tags.forEach(function (t) {
            tagsList.push(t.text);
        });
        hiddenInput.value = tagsList.join(',');
    }

    function filterTag (tag) {
        return tag.replace(/[^\w -]/g, '').trim().replace(/\W+/g, '-');
    }

});
    
[].forEach.call(document.getElementsByClassName('tags_local'), function (el) {
    
    let hiddenInput = document.createElement('input'),
        mainInput = document.createElement('input'),
        tags = [];
    
    //mainInput.setAttribute('placeholder', 'IDs de Locais de Atividade');
    mainInput.setAttribute('id', 'input_locais');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('id', 'hidden_locais');
    hiddenInput.setAttribute('name', el.getAttribute('data-name'));

    mainInput.setAttribute('type', 'text');
    mainInput.classList.add('main-input');

    /*mainInput.addEventListener('input', function () {
        let enteredTags = mainInput.value.split(',');
        if (enteredTags.length > 1) {
            enteredTags.forEach(function (t) {
                let filteredTag = filterTag(t);
                if (filteredTag.length > 0 ){
                    if(!(hiddenInput.value.includes(filteredTag))){
                        addTag(filteredTag);
                    }else{
                        alert('Nao pode haver IDs repetidos');
                        //removeTag(hiddenInput.value.indexOf(filteredTag));
                        delete(filteredTag);
                    }
                }

            });
            mainInput.value = '';
        }
    });*/

    mainInput.addEventListener('keydown',function(e){
        let enteredTags = [];
        if (e.keyCode === 13) {
            
            enteredTags = mainInput.value;
            var aux_j = 0;
            var json_data;
            $.getJSON("http://192.168.3.1/storage/locais.json", function(json) {
                //console.log(json)

                json_data = json;

                let enteredTags_ = [];
                let k = 0;
                let aux = '';
                for (let i = 0; i < enteredTags.length; i++) {
                   if (enteredTags[i] != ",") {
                        aux = aux + enteredTags[i];
                        enteredTags_[k] = aux;
                       
                   }else{
                        k++;
                        aux = '';
                   }
                    
                }
    
                //console.log(enteredTags_)
    
                if (enteredTags_.length > 0 ) {
                    enteredTags_.forEach(function(t){
                        var aux_j = 0;
                        let filteredTag = filterTag(t);
                        for(var i in json_data){
                            //console.log(json_data [i])
                            if (filteredTag == json_data [i]) {
                                aux_j++;
                            }
        
                            
                            //console.log(aux)
                        }

                        if (aux_j == 0) {
                            alert('Local inserido não existe!!');
                            delete(filteredTag);
                        }else{
                            if(!(hiddenInput.value.includes(filteredTag))){
                                addTag(filteredTag);
                                
                            }else{
                                alert('Nao pode haver IDs repetidos');
                                delete(filteredTag);
                            }
                        }

                    })
    
                    mainInput.value = '';
                }
    


            });

            /*if (enteredTags.length > 0) {
                //alert(enteredTags);
                //
                    let filteredTag = filterTag(enteredTags);
                    if (filteredTag.length > 0 ){
                        if(!(hiddenInput.value.includes(filteredTag))){
                            addTag(filteredTag);
                            //console.log(filteredTag)
                        }else{
                            alert('Nao pode haver IDs repetidos');
                            //removeTag(hiddenInput.value.indexOf(filteredTag));
                            delete(filteredTag);
                        }
                    }
                
                mainInput.value = '';
                
            }*/
        }

       
    })

    mainInput.addEventListener('keydown', function (e) {
        let keyCode = e.which || e.keyCode;
        if (keyCode === 8 && mainInput.value.length === 0 && tags.length > 0) {
            removeTag(tags.length - 1);
        }
    });

    el.appendChild(mainInput);
    el.appendChild(hiddenInput);

    

    function addTag (text) {
        let tag = {
            text: text,
            element: document.createElement('span'),
        };

        tag.element.classList.add('tag');
        tag.element.textContent = tag.text;



        let closeBtn = document.createElement('span');

        closeBtn.classList.add('close');
        closeBtn.addEventListener('click', function () {
            removeTag(tags.indexOf(tag));
        });
        tag.element.appendChild(closeBtn);


 
        tags.push(tag);

        //console.log(tags);

        el.insertBefore(tag.element, mainInput);

        refreshTags();


    }

    function removeTag (index) {
        let tag = tags[index];
        tags.splice(index, 1);
        el.removeChild(tag.element);
        refreshTags();
    }

    function refreshTags () {
        let tagsList = [];
        
        tags.forEach(function (t) {
            tagsList.push(t.text);
        });
        //
        hiddenInput.value = tagsList.join(',');
        //console.log(hiddenInput.value);
    }

    function filterTag (tag) {
        return tag.replace().trim().replace();
    }

});



                                    
 

