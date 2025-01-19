// Sample data for products
const products = [
    { id: 1, name: 'Modern Chair', image: 'img/bg-img/7.jpg', price: 180 },
    { id: 2, name: 'Luxury Sofa', image: 'img/bg-img/8.jpg', price: 250 },
    { id: 3, name: 'Wooden Table', image: 'img/bg-img/9.jpg', price: 150 },
];

let currentProduct = null;

// Function to render the product table
function renderProductTable() {
    const tableBody = document.querySelector('#product-table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    products.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td><img src="${product.image}" alt="${product.name}" width="50" height="50"></td>
            <td>$${product.price}</td>
            <td>
                <button class="btn edit-btn" onclick="editProduct(${product.id})">Edit</button>
                <button class="btn delete-btn" onclick="deleteProduct(${product.id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Function to open the modal for adding/editing products
function openProductModal() {
    document.getElementById('product-modal').style.display = 'block';
}

// Function to close the modal
function closeProductModal() {
    document.getElementById('product-modal').style.display = 'none';
}

// Function to edit a product
function editProduct(id) {
    currentProduct = products.find(product => product.id === id);
    if (currentProduct) {
        document.getElementById('product-name').value = currentProduct.name;
        document.getElementById('product-price').value = currentProduct.price;
        document.getElementById('modal-title').textContent = 'Edit Product';
        openProductModal();
    }
}

// Function to delete a product
function deleteProduct(id) {
    const productIndex = products.findIndex(product => product.id === id);
    if (productIndex !== -1) {
        products.splice(productIndex, 1);
        renderProductTable();
    }
}

// Handle form submit for adding/editing products
document.getElementById('product-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('product-name').value;
    const price = parseFloat(document.getElementById('product-price').value);
    const image = document.getElementById('product-image').files[0];

    if (currentProduct) {
        // Edit product
        currentProduct.name = name;
        currentProduct.price = price;
        currentProduct.image = URL.createObjectURL(image);  // For demonstration (you'll handle file upload in the backend)
    } else {
        // Add new product
        const newProduct = {
            id: products.length + 1,
            name,
            price,
            image: URL.createObjectURL(image)  // For demonstration
        };
        products.push(newProduct);
    }

    renderProductTable();
    closeProductModal();
    currentProduct = null;
});

// Event listener for closing the modal
document.getElementById('close-modal').addEventListener('click', closeProductModal);

// Initial render of the product table
renderProductTable();

// Add Product Button Event
document.getElementById('add-product-btn').addEventListener('click', function() {
    document.getElementById('modal-title').textContent = 'Add Product';
    openProductModal();
});
