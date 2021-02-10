/**
 * Ouvre la modale d'édition d'un voyage au clic sur son bouton "editer"
 */
$(document).on("click", ".openEditModal", function () {
    let travelId = $(this).data('id');
    if (travelId) {
        getTravelById(travelId);
    }
});

//Reset la modale pour ne pas se retrouver avec des valeurs d'une modales ouverte précédement
let template = null;
$('.modal').on('show.bs.modal', function(event) {
    template = $(this).html();
});

$('.modal').on('hidden.bs.modal', function(e) {
    $(this).html(template);
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
                //console.log(json);
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

            stepsTabs.appendChild(createDivItem(stages[i].id,'a', 0));
            let div = createDivItem(stages[i].id,'div', 0);
            let p = createDivItem(stages[i].id,'p');
            p.textContent = `Départ : ${stages[i].departure}. Arrivée : ${stages[i].arrival}. Numéro : ${stages[i].number}. Date de départ : ${stages[i].departure_date}. Date d'arrivée : ${stages[i].arrival_date}`;
            div.appendChild(p);
            stepsTabsContent.appendChild(div);
        } else {
            stepsTabs.appendChild(createDivItem(stages[i].id,'a'));
            let div = createDivItem(stages[i].id,'div');
            let p = createDivItem(stages[i].id,'p');
            p.textContent = `Départ : ${stages[i].departure}. Arrivée : ${stages[i].arrival}. Numéro : ${stages[i].number}. Date de départ : ${stages[i].departure_date}. Date d'arrivée : ${stages[i].arrival_date}`;
            div.appendChild(p);
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
 * Après modification du DOM on appelle cette fonction
 * afin d'écouter le clique sur le bouton d'ajout d'une étape.
 * Au clique on supprime l'alerte rouge ainsi que le bouton d'ajout.
 * @param domElement
 */
function listenMyClick(domElement) {
    const addStage = document.getElementById("add-stage");
    if (addStage) {
        addStage.addEventListener("click", (event) => {
            console.log("click ajout étape");
            getStages();
            const stagesChoice = document.getElementById("stages-choice");
            stagesChoice.classList.remove("hidden");
            //On supprime le bouton et l'alerte rouge (2 fois le 1 car fonctionne comme un tableau. On supprime les clefs sans toucher à la clef
            //zéro qui est le select en hidden.
            domElement.removeChild(domElement.childNodes[1]);
            domElement.removeChild(domElement.childNodes[1]);
        });
    }
}

/**
 * Fonction qui modifie le dom en créant de nouvelles balises html selon leur type et les retourne.
 * @param id
 * @param type
 * @param number
 * @returns {*}
 */
function createDivItem(id, type, number = 1) {
    let balise = document.createElement(type);

    if (type === 'a') {
        balise.classList = (number === 0) ? 'nav-item nav-link active show' : 'nav-item nav-link';
        balise.setAttribute('href', `#nav-${id}`);
        balise.setAttribute('data-toggle', `tab`);
        balise.setAttribute('role', `tab`);
        balise.setAttribute('aria-controls', `nav-${id}`);
        (number === 0) ? balise.setAttribute('aria-selected', true) : balise.setAttribute('aria-selected', false);
        balise.setAttribute('id', `nav-${id}-tab`);
        balise.textContent = `Etape ${id}`;
    } else if (type === 'div') {
        balise.classList = (number === 0) ? 'tab-pane fade active show' : 'tab-pane fade';
        balise.setAttribute('id', `nav-${id}`);
        balise.setAttribute('role', `tabpanel`);
        balise.setAttribute('aria-labelledby', `nav-${id}-tab`);
    }

    return balise;
}
