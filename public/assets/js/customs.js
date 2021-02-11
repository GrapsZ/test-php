/**
 * Ouvre la modale d'édition d'un voyage au clic sur son bouton "editer"
 */
$(document).on("click", ".openEditModal", function () {
    let travelId = $(this).data('id');
    if (travelId) {
        getTravelById(travelId);
        resetModal();
    }
});

/**
 * Récupère les informations d'un voyage (prix, nom, étapes, etc...)
 * @param id
 */
function getTravelById(id) {
    const travel = {id: id};
    $.ajax({
        url: `api/showtravel/${travel.id}`,
        type: 'GET',
        dataType: 'JSON',
        success: function (json) {
            if (json) {
                console.log(json);
                if (json.success) {
                    const name = document.getElementById("name-editor");
                    const price = document.getElementById("price-editor");
                    const title = document.getElementById("title-editor");
                    const active = document.getElementById("active-editor");
                    const id = document.getElementById("id-editor");

                    name.value = json.data.name;
                    price.value = json.data.price;
                    title.innerHTML = `Modification du voyage pour ${json.data.name}`;
                    active.checked = json.data.is_active;
                    id.value = json.data.id;

                    constructStagesCards(json.data.stages);
                    getStages(json.data.stages)
                }
            } else {
                console.log('Erreur de retour json');
            }
        },
        error: function (json) {
            console.log(json);
        }
    });
}

/**
 * Recupère la liste des étapes disponibles dans la base de données puis mets tout en forme dans un
 * select multiple.
 *
 * stages est défini à vide. Cependant lorsqu'elle est passée sous forme de tableau, elle sert à boucler sur ses éléments
 * et donc à selectionner les options du select qui ont pour valeur l'id du stage sur lequel nous bouclons
 * @param stages
 */
function getStages(stages = []) {
    $.ajax({
        url: `api/showtravels`,
        type: 'GET',
        dataType: 'JSON',
        success: function (json) {
            if (json) {
                if (json.success) {
                    const multiSelector = document.getElementById("multiple-stage");
                    let total = json.data.length;
                    for (let i = 0; i < total; i++) {
                        let opt = document.createElement('option');
                        opt.value = json.data[i].id;
                        opt.text = `Depart: ${json.data[i].departure} - Arrivée: ${json.data[i].arrival}`
                        multiSelector.add(opt);
                    }

                    if (stages.length > 0) {
                        //Si on a des étapes passées, on récupère toutes les options du selecteur
                        const options = document.getElementsByTagName("option");
                        for (let j = 0; j < stages.length; j++) {
                            //on boucle sur les options
                            for (let k = 0; k < options.length; k++) {
                               //Si la valeur de l'option est égale à l'id du stage, alors on select notre option
                                if (parseInt(options[k].value) === stages[j].id) {
                                    options[k].selected = true;
                                }
                            }
                        }
                    }
                }
            } else {
                console.log('Erreur de retour json');
            }
        },
        error: function (json) {
            console.log(json);
        }
    });
}

/**
 * Fonction qui met en place l'affichage des étapes par voyage dans la modale d'édition
 * @param stages
 */
function constructStagesCards(stages) {
    const totalStages = stages.length;
    const stepsTabs = document.getElementById("nav-tab-editor");
    const stepsTabsContent = document.getElementById("nav-tabContent");

    for (let i = 0; i < totalStages; i++) {
        if (i === 0) {
            //On a des éléments (stages) pour ce voyage. On décache donc l'ajout de nouvelles étapes.
            const stagesChoice = document.getElementById("stages-choice");
            stagesChoice.classList.remove("hidden");

            stepsTabs.appendChild(createDivItem(stages[i],'a', 0));
            let div = createDivItem(stages[i],'div', 0);
            let p = createDivItem(stages[i],'p');
            let hr = createDivItem(stages[i],'hr')
            let p1 = createDivItem(stages[i],'p');
            let p2 = createDivItem(stages[i],'p');
            let p3 = createDivItem(stages[i],'p');
            let p4 = createDivItem(stages[i],'p');

            p.innerHTML = `Voici les informations enregistrée de cette étape, en partance de <b>${stages[i].departure}</b> et à destination de <b>${stages[i].arrival}</b>.`;
            p1.innerHTML = `Départ de : <b>${stages[i].departure}</b> le ${stages[i].departure_date}.`;
            p2.innerHTML = `Arrivée à : <b>${stages[i].arrival}</b> le ${stages[i].arrival_date}.`;

            p3.innerHTML = (stages[i].number === null) ? 'Numéro: <b>Non défini</b> | ' : 'Numéro: <b>' + stages[i].number + '</b> | ';
            p3.innerHTML += (stages[i].seat === null) ? 'Siège: <b>Non défini</b>' : 'Siège: <b>' + stages[i].seat + '</b>';

            p4.innerHTML = (stages[i].gate === null) ? 'Porte: <b>Non définie</b> | ' : 'Porte: <b>' + stages[i].gate + '</b> | ';
            p4.innerHTML += (stages[i].baggage_drop === null) ? 'Dépôt de bagages: <b>Non défini</b>' : 'Dépôt de bagages: <b>' + stages[i].baggage_drop + '</b>';

            div.appendChild(p);
            div.appendChild(hr);
            div.appendChild(p1);
            div.appendChild(p2);
            div.appendChild(p3);
            div.appendChild(p4);
            stepsTabsContent.appendChild(div);
        } else {
            stepsTabs.appendChild(createDivItem(stages[i],'a'));
            let div = createDivItem(stages[i],'div');

            let p = createDivItem(stages[i],'p');
            let hr = createDivItem(stages[i],'hr')
            let p1 = createDivItem(stages[i],'p');
            let p2 = createDivItem(stages[i],'p');
            let p3 = createDivItem(stages[i],'p');
            let p4 = createDivItem(stages[i],'p');

            p.innerHTML = `Voici les informations enregistrée de cette étape, en partance de <b>${stages[i].departure}</b> et à destination de <b>${stages[i].arrival}</b>.`;
            p1.innerHTML = `Départ de : <b>${stages[i].departure}</b> le ${stages[i].departure_date}.`;
            p2.innerHTML = `Arrivée à : <b>${stages[i].arrival}</b> le ${stages[i].arrival_date}.`;

            p3.innerHTML = (stages[i].number === null) ? 'Numéro: <b>Non défini</b> | ' : 'Numéro: <b>' + stages[i].number + '</b> | ';
            p3.innerHTML += (stages[i].seat === null) ? 'Siège: <b>Non défini</b>' : 'Siège: <b>' + stages[i].seat + '</b>';

            p4.innerHTML = (stages[i].gate === null) ? 'Porte: <b>Non définie</b> | ' : 'Porte: <b>' + stages[i].gate + '</b> | ';
            p4.innerHTML += (stages[i].baggage_drop === null) ? 'Dépôt de bagages: <b>Non défini</b>' : 'Dépôt de bagages: <b>' + stages[i].baggage_drop + '</b>';

            div.appendChild(p);
            div.appendChild(hr);
            div.appendChild(p1);
            div.appendChild(p2);
            div.appendChild(p3);
            div.appendChild(p4);
            stepsTabsContent.appendChild(div);
        }
    }

    if (totalStages === 0) {
        let balise = document.createElement('p');
        balise.innerText = `Aucune étape associée à ce voyage.`;
        balise.setAttribute("class", "error");
        let button = document.createElement('a');
        button.innerText = "Ajouter une étape";
        button.setAttribute("class", "btn btn-primary white");
        button.setAttribute("id", "add-stage");

        stepsTabsContent.appendChild(balise);
        stepsTabsContent.appendChild(button);

        listenMyClick(stepsTabsContent);
    }
}

/**
 * Fonction qui est appelée pour réinitialiser le contenu de la modale d'édition d'un
 * voyage pour gérer les ouvertures / fermetures des utilisateurs
 */
function resetModal() {
    //Reset jquery validator
    let form = $('#travel-form-editor');
    let validator = form.validate();
    validator.resetForm();

    //multi select
    const multiSelect = document.getElementById("multiple-stage");
    multiSelect.innerHTML = "";
    //Div contenant le multiu select des étapes. (On la cache)
    const stagesChoiceElement = document.getElementById("stages-choice");
    stagesChoiceElement.classList.add("hidden");
    //reset des tuiles/ cards d'étapes
    const stepsTabs = document.getElementById("nav-tab-editor");
    stepsTabs.innerHTML = "";
    //reset du contenu des tuiles / cards d'étapes
    const stepsTabsContent = document.getElementById("nav-tabContent");
    stepsTabsContent.innerHTML = "";
    //reset du nom du voyage
    const nameEditor = document.getElementById("name-editor");
    nameEditor.value = "";
    //reset du prix du voyage
    const priceEditor = document.getElementById("price-editor");
    priceEditor.value = "";
}

/**
 * Après modification du DOM on appelle cette fonction
 * afin d'écouter le clique sur le bouton d'ajout d'une étape.
 * Au clique on supprime l'alerte rouge ainsi que le bouton d'ajout.
 * @param domElement
 */
function listenMyClick(domElement) {
    const addStage = document.getElementById("add-stage");
    if (addStage) {
        addStage.addEventListener("click", (event) => {
            //on affiche la balise contenant le multi selector
            const stagesChoice = document.getElementById("stages-choice");
            stagesChoice.classList.remove("hidden");
            //On supprime le bouton et l'alerte rouge (suppression par la key)
            domElement.removeChild(domElement.childNodes[1]); // Bouton
            domElement.removeChild(domElement.childNodes[0]); // Message d'alerte
        });
    }
}

/**
 * Fonction qui modifie le dom en créant de nouvelles balises html selon leur type et les retourne.
 * @param json
 * @param type
 * @param number
 * @returns {*}
 */
function createDivItem(json, type, number = 1) {
    let balise = document.createElement(type);

    if (type === 'a') {
        balise.classList = (number === 0) ? 'nav-item nav-link active show' : 'nav-item nav-link';
        balise.setAttribute('href', `#nav-${json.id}`);
        balise.setAttribute('data-toggle', `tab`);
        balise.setAttribute('role', `tab`);
        balise.setAttribute('aria-controls', `nav-${json.id}`);
        (number === 0) ? balise.setAttribute('aria-selected', true) : balise.setAttribute('aria-selected', false);
        balise.setAttribute('id', `nav-${json.id}-tab`);
        balise.textContent = `Etape: ${json.departure} => ${json.arrival}`;
    } else if (type === 'div') {
        balise.classList = (number === 0) ? 'tab-pane fade active show' : 'tab-pane fade';
        balise.setAttribute('id', `nav-${json.id}`);
        balise.setAttribute('role', `tabpanel`);
        balise.setAttribute('aria-labelledby', `nav-${json.id}-tab`);
    }

    return balise;
}