// Form validation utility
const FormUtils = {
    validate(form) {
        const isValid = form.checkValidity();
        if (!isValid) {
            form.classList.add('was-validated');
        }
        return isValid;
    },

    resetForm(form) {
        if (form) {
            form.reset();
            form.classList.remove('was-validated');
        }
    }
};

// API calls handling
const ApiService = {
    async fetchProduct(productId) {
        try {
            const response = await fetch(`/estoque/produto/${productId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            return await response.json();
        } catch (error) {
            console.error('Erro buscando produtos:', error);
            throw error;
        }
    },

    async fetchProductDetails(productId) {
        try {
            const response = await fetch(`/estoque/detalhes/${productId}`);
            return await response.json();
        } catch (error) {
            console.error('Erro buscando detalhes dos produtos:', error);
            throw error;
        }
    },

    async submitForm(form) {
        try {
            const response = await fetch(form.action, {
                method: form.method,
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            return await response.json();
        } catch (error) {
            console.error('Error ao enviar o formulário:', error);
            throw error;
        }
    }
};

// UI notifications handling
const NotificationService = {
    async showSuccess(message, callback) {
        const result = await Swal.fire({
            title: 'Sucesso!',
            text: message,
            icon: 'success',
            confirmButtonText: 'Fechar'
        });
        if (callback) callback(result);
    },

    async showError(message) {
        await Swal.fire({
            title: 'Erro!',
            text: message,
            icon: 'error',
            confirmButtonText: 'Fechar'
        });
    },

    async showDeleteConfirmation() {
        return Swal.fire({
            title: 'Tem certeza?',
            text: 'Você não poderá reverter isso!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar'
        });
    }
};

// Product information handling
const ProductManager = {
    categoryMap: {
        'eletronic': 'Eletrônicos',
        'furniture': 'Móveis',
        'raw_material': 'Vestuário',
        'others': 'Outros'
    },

    unitMap: {
        'pcs': 'Peças',
        'kg': 'Quilogramas',
        'g': 'Gramas',
        'l': 'Litros',
        'ml': 'Mililitros',
        'm': 'Metros',
        'cm': 'Centímetros',
        'un': 'Unidades'
    },

    async updateProductInfo(productId, modalPrefix) {
        if (!productId) {
            document.getElementById(`${modalPrefix}_product_info`).style.display = 'none';
            return;
        }

        try {
            const { success, product } = await ApiService.fetchProduct(productId);
            if (success) {
                this.displayProductInfo(product, modalPrefix);
            }
        } catch (error) {
            NotificationService.showError('Erro ao buscar informações do produto.');
        }
    },

    displayProductInfo(product, modalPrefix) {
        const productInfoDiv = document.getElementById(`${modalPrefix}_product_info`);
        const elements = {
            amount: productInfoDiv.querySelector('.product-amount'),
            price: document.getElementById(`${modalPrefix}_product_price`),
            minimum: productInfoDiv.querySelector('.product-minimum'),
            totalPrice: productInfoDiv.querySelector('.product-total-price')
        };

        elements.amount.innerText = product.amount || '';
        elements.price.value = product.price ? parseFloat(product.price).toFixed(2) : '';
        elements.minimum.innerText = product.minimum_stock || '';
        elements.totalPrice.innerText = product.total_price ? parseFloat(product.total_price).toFixed(2) : '';
        productInfoDiv.style.display = 'block';

        if (modalPrefix === 'sell') {
            const amountInput = document.getElementById(`${modalPrefix}_amount`);
            const maxAmount = product.amount - product.minimum_stock;
            amountInput.max = maxAmount;
            amountInput.setAttribute('max', maxAmount);
        }
    },

    calculateTotal() {
        const getValue = (id) => parseFloat(document.getElementById(id).value) || 0;
        
        const buyAmount = getValue('buy_amount');
        const buyPrice = getValue('buy_product_price');
        const sellAmount = getValue('sell_amount');
        const sellPrice = getValue('sell_product_price');

        if (buyAmount > 0) {
            document.getElementById('buy_total_price').value = (buyAmount * buyPrice).toFixed(2);
        } else if (sellAmount > 0) {
            document.getElementById('sell_total_price').value = (sellAmount * sellPrice).toFixed(2);
        }
    },

    populateDetailsModal(product) {
        try {
            const setDetail = (id, value, defaultText = 'Não informado') => {
                document.getElementById(id).textContent = value || defaultText;
            };

            setDetail('detail-product-id', product.product_id);
            setDetail('detail-name', product.name);
            setDetail('detail-category', this.categoryMap[product.category]);
            setDetail('detail-unit', this.unitMap[product.unit]);
            setDetail('detail-amount', product.amount);
            setDetail('detail-price', parseFloat(product.price).toFixed(2));
            setDetail('detail-description', product.description);
            setDetail('detail-sku', product.sku);
            setDetail('detail-barcode', product.barcode);
            setDetail('detail-supplier', product.supplier);
            setDetail('detail-supplier-contact', product.supplier_contact);
            setDetail('detail-brand', product.brand);
            setDetail('detail-location', product.location);
            setDetail('detail-minimum-stock', product.minimum_stock);
            setDetail('detail-status', product.is_active == 1 ? 'Ativo' : 'Inativo');
        } catch (error) {
            console.error('Erro ao preencher modal:', error);
            NotificationService.showError('Erro ao exibir detalhes do produto.');
        }
    },

    populateEditModal(product) {
        const setValue = (id, value) => {
            const element = document.getElementById(id);
            if (element) element.value = value || '';
        };

        setValue('edit-product-id', product.product_id);
        setValue('edit-name', product.name);
        setValue('edit-category', product.category);
        setValue('edit-unit', product.unit);
        setValue('edit-price', parseFloat(product.price).toFixed(2));
        setValue('edit-description', product.description);
        setValue('edit-sku', product.sku);
        setValue('edit-barcode', product.barcode);
        setValue('edit-supplier', product.supplier);
        setValue('edit-supplier-contact', product.supplier_contact);
        setValue('edit-brand', product.brand);
        setValue('edit-location', product.location);
        setValue('edit-minimum-stock', product.minimum_stock || '1');
        setValue('edit-status', product.is_active != null ? product.is_active.toString() : '1');
    }
    
};

// Modal handling
const ModalManager = {
    async handleSave(modalId) {
        const modal = document.getElementById(modalId);
        const form = modal.querySelector('form');

        if (!FormUtils.validate(form)) {
            return;
        }

        try {
            const data = await ApiService.submitForm(form);
            if (data.success) {
                await NotificationService.showSuccess('Ação concluída com sucesso.', () => {
                    FormUtils.resetForm(form);
                    modal.classList.remove('show');
                    document.location.reload();
                });
            } else {
                await NotificationService.showError(data.message || 'Erro ao processar os dados.');
            }
        } catch (error) {
            await NotificationService.showError('Ocorreu um erro inesperado.');
        }
    },

    setupModalListeners() {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', () => {
                const form = modal.querySelector('form');
                const productInfoDiv = modal.querySelector('.product-info');
                
                FormUtils.resetForm(form);
                if (productInfoDiv) {
                    productInfoDiv.style.display = 'none';
                }
            });
        });
    },

    async openEditModal(productId) {
        try {
            const data = await ApiService.fetchProduct(productId);
            if (data.success) {
                ProductManager.populateEditModal(data.product);
                const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                editModal.show();
            } else {
                await NotificationService.showError(data.message || 'Erro ao carregar informações do produto.');
            }
        } catch (error) {
            console.error('Erro ao carregar produto:', error);
            await NotificationService.showError('Erro ao carregar informações do produto.');
        }
    },

    async handleEditSubmit(form) {
        if (!FormUtils.validate(form)) {
            return;
        }

        try {
            const data = await ApiService.submitForm(form);
            if (data.success) {
                await NotificationService.showSuccess('Produto atualizado com sucesso!', () => {
                    bootstrap.Modal.getInstance(document.getElementById('editProductModal')).hide();
                    window.location.reload();
                });
            } else {
                await NotificationService.showError(data.message || 'Erro ao atualizar o produto.');
            }
        } catch (error) {
            console.error('Erro ao atualizar produto:', error);
            await NotificationService.showError('Erro ao atualizar o produto.');
        }
    }
};

// Initialize application
document.addEventListener('DOMContentLoaded', () => {
    // Setup form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            if (form.action.includes('estoque/deletar')) {
                const result = await NotificationService.showDeleteConfirmation();
                if (result.isConfirmed) {
                    try {
                        const data = await ApiService.submitForm(form);
                        if (data.success) {
                            await NotificationService.showSuccess('O produto foi deletado.', () => {
                                document.location.reload();
                            });
                        } else {
                            await NotificationService.showError(data.message || 'Erro ao deletar o produto.');
                        }
                    } catch (error) {
                        await NotificationService.showError('Ocorreu um erro inesperado.');
                    }
                }
            }
        });
    });

    // Setup modal save buttons
    const setupSaveButton = (modalId, buttonId) => {
        const button = document.getElementById(modalId)?.querySelector(`#${buttonId}`);
        if (button) {
            button.addEventListener('click', () => ModalManager.handleSave(modalId));
        }
    };

    setupSaveButton('addProductModal', 'saveProduct');
    setupSaveButton('buyProductModal', 'saveBuyProduct');
    setupSaveButton('sellProductModal', 'saveSellProduct');

    // Setup product info updates
    ['buy', 'sell'].forEach(prefix => {
        const select = document.getElementById(`product_id_${prefix}`);
        if (select) {
            select.addEventListener('change', (e) => ProductManager.updateProductInfo(e.target.value, prefix));
        }
    });

    // Setup total calculation listeners
    ['buy_amount', 'buy_product_price', 'sell_amount', 'sell_product_price'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', () => ProductManager.calculateTotal());
    });

    document.querySelectorAll('.btn-info.btn-sm').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = button.getAttribute('data-product-id');
            
            try {
                const data = await ApiService.fetchProductDetails(productId);
                if (data.success) {
                    ProductManager.populateDetailsModal(data.product);
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('detailProductModal')).show();
                } else {
                    await NotificationService.showError(data.message || 'Erro ao buscar informações do produto.');
                }
            } catch (error) {
                console.error('Erro: ', error);
                await NotificationService.showError('Erro ao carregar os detalhes do produto.');
            }
        });
    });

    // Setup edit buttons
    document.querySelectorAll('.btn-primary.btn-sm').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const productId = button.closest('tr').querySelector('td:first-child').textContent;
            ModalManager.openEditModal(productId);
        });
    });

    // Setup edit form submission
    const editForm = document.querySelector('#editProductModal form');
    if (editForm) {
        editForm.addEventListener('submit', (e) => {
            e.preventDefault();
            ModalManager.handleEditSubmit(editForm);
        });
    }

    // Setup price input formatting
    const editPriceInput = document.getElementById('edit-price');
    if (editPriceInput) {
        editPriceInput.addEventListener('change', function() {
            this.value = parseFloat(this.value).toFixed(2);
        });
    }

    // Setup edit modal reset
    const editModal = document.getElementById('editProductModal');
    if (editModal) {
        editModal.addEventListener('hidden.bs.modal', function() {
            const form = this.querySelector('form');
            FormUtils.resetForm(form);
        });
    }

    ModalManager.setupModalListeners();
});