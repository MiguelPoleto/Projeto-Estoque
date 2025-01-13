function calculateTotalForSale() {
    const amount = parseFloat(document.getElementById('sale_amount').value) || 0;
    const price = parseFloat(document.getElementById('sale_price').value) || 0;
    const total = amount * price;
    document.getElementById('sale_total_price').value = total.toFixed(2);
}
document.getElementById('sale_amount').addEventListener('input', calculateTotalForSale);
document.getElementById('sale_price').addEventListener('input', calculateTotalForSale);


function validateForm(form) {
    const isValid = form.checkValidity();
    if (!isValid) {
        form.classList.add('was-validated');
    }
    return isValid;
}

document.addEventListener("DOMContentLoaded", () => {
    const confirmationCard = document.getElementById("confirmationCard");
    const confirmationEditCard = document.getElementById("confirmationEditCard");
    const confirmName = document.getElementById("confirmName");
    const confirmID = document.getElementById("confirmID");
    const confirmOption = document.getElementById("confirmOption");
    const confirmCategory = document.getElementById("confirmCategory");
    const confirmAmount = document.getElementById("confirmAmount");
    const confirmPrice = document.getElementById("confirmPrice");
    const confirmTotalPrice = document.getElementById("confirmTotalPrice");

    const handleModalConfirmation = (modalId) => {
        const modal = document.getElementById(modalId);
        const form = modal.querySelector("form");

        if (modalId === 'addProductModal') {

            const name = form.querySelector("#name")?.value || "Não informado";
            const category = form.querySelector("#category")?.selectedOptions[0]?.text || "Não informado";
            const amount = form.querySelector("#amount")?.value || "0";
            const price = form.querySelector("#price")?.value || "0,00";

            confirmName.innerText = name;
            confirmCategory.innerText = category;
            confirmAmount.innerText = amount;
            confirmPrice.innerText = price;

            const bootstrapModal = bootstrap.Modal.getInstance(modal);
            if (bootstrapModal) bootstrapModal.hide();

            setTimeout(() => {
                const backdrops = document.querySelectorAll(".modal-backdrop");
                backdrops.forEach((backdrop) => backdrop.remove());

                confirmationCard.classList.remove("d-none");
                confirmationCard.style.display = "block";
            }, 300);
        } else {

            const id = form.querySelector("#product_id")?.value || "Não informado";
            const option = form.querySelector("#product_option")?.selectedOptions[0]?.text || "Não informado";
            const amount = form.querySelector("#sale_amount")?.value || "0";
            const price = form.querySelector("#sale_price")?.value || "0,00";
            const totalPrice = form.querySelector("#sale_total_price")?.value || "0,00";

            confirmID.innerText = id;
            confirmOption.innerText = option;
            confirmSaleAmount.innerText = amount;
            confirmSalePrice.innerText = price;
            confirmTotalPrice.innerText = totalPrice;

            const bootstrapModal = bootstrap.Modal.getInstance(modal);
            if (bootstrapModal) bootstrapModal.hide();

            setTimeout(() => {
                const backdrops = document.querySelectorAll(".modal-backdrop");
                backdrops.forEach((backdrop) => backdrop.remove());

                confirmationEditCard.classList.remove("d-none");
                confirmationEditCard.style.display = "block";
            }, 300);
        }

    };


    const addProductSaveBtn = document.getElementById("addProductModal").querySelector("#saveProduct");
    const editProductSaveBtn = document.getElementById("editProductModal").querySelector("#saveSaleProduct");

    if (addProductSaveBtn) {
        addProductSaveBtn.addEventListener("click", () => {
            const form = document.getElementById('addProductModal').querySelector('form');
            if (validateForm(form)) {
                handleModalConfirmation("addProductModal");
            }
        });
    }

    if (editProductSaveBtn) {
        editProductSaveBtn.addEventListener("click", () => {
            const form = document.getElementById('editProductModal').querySelector('form');
            if (validateForm(form)) {
                handleModalConfirmation("editProductModal");
            }
        });
    }

    document.getElementById("cancelConfirmation").addEventListener("click", () => {
        Swal.fire({
            title: 'Cancelado!',
            text: 'Ação desfeita com sucesso.',
            icon: 'error',
            confirmButtonText: 'Fechar',
        }).then(() => {
            location.reload();
        });
    });
    document.getElementById("confirmSave").addEventListener("click", () => {
        Swal.fire({
            title: 'Produto Salvo!',
            text: 'Seu produto foi salvo com sucesso.',
            icon: 'success',
            confirmButtonText: 'Fechar',
        }).then(() => {
            location.reload();
        });
    });

    document.getElementById("cancelSaleConfirmation").addEventListener("click", () => {
        Swal.fire({
            title: 'Cancelado!',
            text: 'Ação desfeita com sucesso.',
            icon: 'error',
            confirmButtonText: 'Fechar',
        }).then(() => {
            location.reload();
        });
    });
    document.getElementById("confirmSaleSave").addEventListener("click", () => {
        Swal.fire({
            title: 'Ação Concluída!',
            text: 'A venda ou compra foi registrada com sucesso.',
            icon: 'success',
            confirmButtonText: 'Fechar',
        }).then(() => {
            location.reload();
        });
    });
});