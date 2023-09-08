const sideMenu = document.querySelector('aside');
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-btn');

const darkMode = document.querySelector('.dark-mode');

menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
});

darkMode.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode-variables');
    darkMode.querySelector('span:nth-child(1)').classList.toggle('active');
    darkMode.querySelector('span:nth-child(2)').classList.toggle('active');
})

const viewMoreLink = document.querySelector('a[href="load_more.php"]');
let offset = 4; // Start with the next set of orders

viewMoreLink.addEventListener('click', (event) => {
    event.preventDefault();

    // Make an AJAX request to load_more.php
    fetch(`load_more.php?offset=${offset}`)
        .then(response => response.text())
        .then(data => {
            // Append the new orders to the table
            document.querySelector('table tbody').innerHTML += data;

            // Increment the offset for the next request
            offset += 4;
        })
        .catch(error => console.error('Error:', error));
});

const moreUserDiv = document.querySelector('.more');
const userContainer = document.querySelector('.user-list');
let userOffset = 3;

moreUserDiv.addEventListener('click', () => {
    fetch(`load_more_users.php?offset=${userOffset}`)
        .then(response => response.text())
        .then(data => {
            userContainer.innerHTML = data;
            userOffset += 3;
        })
        .catch(error => console.error('Error:', error));
});



// Orders.forEach(order => {
//     const tr = document.createElement('tr');
//     const trContent = `
//         <td>${order.productName}</td>
//         <td>${order.productNumber}</td>
//         <td>${order.paymentStatus}</td>
//         <td class="${order.status === 'Declined' ? 'danger' : order.status === 'Pending' ? 'warning' : 'primary'}">${order.status}</td>
//         <td class="primary">Details</td>
//     `;
//     tr.innerHTML = trContent;
//     document.querySelector('table tbody').appendChild(tr);
// });