        function verif() {
        const patientId = document.getElementById('patientName').value.trim();
        const patientName = document.getElementById('patientName').value.trim();
        const roomNumber = document.getElementById('roomNumber').value.trim();
        const diet = document.getElementById('diet').value.trim();
        const allergies = document.getElementById('allergie').value.trim();

        if (patientId === "") {
            alert("Le champ Id du patient est vide !");
            event.preventDefault();
            return;
        }
        if (patientName === "") {
            alert("Le champ Nom du patient est vide !");
            event.preventDefault();
            return;
        }

        if (roomNumber === "") {
            alert("Le champ Numéro de chambre est vide !");
            event.preventDefault();
            return;
        }

        if (diet === "") {
            alert("Veuillez sélectionner un régime alimentaire !");
            event.preventDefault();
            return;
        }

        if (allergies === "") {
            alert("Le champ 'Allergies' est vide !");
            event.preventDefault();
            return;
        }
    };
    function verif2() {
        const mealName = document.getElementById('mealName').value.trim();
        const mealDescription = document.getElementById('mealDescription').value.trim();
        const mealQuantity = document.getElementById('mealQuantity').value.trim();
        const mealCategory = document.getElementById('mealCategory').value.trim();


        if (mealName === "") {
            alert("Le champ Nom du Repas est vide !");
            event.preventDefault();
            return;
        }

        if (mealDescription === "") {
            alert("Le champ Description est vide !");
            event.preventDefault();
            return;
        }

        if (mealCategory === "") {
            alert("Veuillez sélectionner une catégorie !");
            event.preventDefault();
            return;
        }

        if (mealQuantity === "") {
            alert("Le champ Quantité est vide !");
            event.preventDefault();
            return;
        }
    };

    function verif3()
    {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const message = document.getElementById('message').value.trim();
        if (name === "") {
            alert("Le champ Nom est vide. Veuillez le remplir.");
            event.preventDefault();  // Empêche l'envoi du formulaire
            return;
        }

        if (email === "") {
            alert("Le champ Email est vide. Veuillez le remplir.");
            event.preventDefault();
            return;
        }
                const email2 = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!email2.test(email)) {
                    alert("L'email que vous avez entré n'est pas valide.");
                    event.preventDefault();
                    return;
                }
        

        if (message === "") {
            alert("Le champ Message est vide. Veuillez le remplir.");
            event.preventDefault();
            return;
        }
    }
    /*function verif4() {
        const form = document.getElementById('addPatientForm');
        const patientsTable = document.getElementById('patientsTable').getElementsByTagName('tbody')[0];
    
        // Tableau simulé pour vérifier les IDs existants
        let patients = [];
    
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Empêche le rechargement de la page
    
            const patientId = document.getElementById('patientId').value.trim();
            const patientName = document.getElementById('patientName').value.trim();
    
            // Vérifier si l'ID existe déjà
            const patientExists = patients.some(patient => patient.id === patientId);
    
            if (patientExists) {
                alert('Patient avec cet ID existe déjà.');
            } else {
                // Ajouter le patient au tableau
                patients.push({ id: patientId, name: patientName });
                // Ajouter une ligne au tableau HTML
                const newRow = patientsTable.insertRow();
                const cellId = newRow.insertCell(0);
                const cellName = newRow.insertCell(1);
    
                cellId.textContent = patientId;
                cellName.textContent = patientName;
    
                alert('Patient ajouté avec succès !');
            }
    
            // Réinitialiser le formulaire
            form.reset();
        });
    }; */
    