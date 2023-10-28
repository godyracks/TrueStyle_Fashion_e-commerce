<style>
   .sticky-footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #333;
    color: #fff;
    padding: 10px 0;
    display: none; /* Hide initially */
    border-radius: 12px;
}

@media (max-width: 768px) {
    .sticky-footer {
        display: block; /* Show on small screens */
    }
}

.sticky-footer nav {
    text-align: center;
}

.sticky-footer ul {
    list-style: none;
    padding: 0;
  display: flex; /* Add this line */
  justify-content: center; /* Add this line */
}

.sticky-footer ul li {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 15px;
}

.sticky-footer ul li a {
    text-decoration: none;
    color: #fff;
}

.menu-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.menu-item i {
    margin-bottom: 5px;
}

/* Styles for the menu popup */
.menu-popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 1;
}

.menu-content {
  
    border-radius: 12px;
    display: flex; /* Add this line */
    flex-direction: column; /* Add this line */
    justify-content: space-between; /* Add this line */
     align-items: center; /*Add this line */
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 40px;
    width: 70%;
    height: 200px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    text-align: center;
    margin: 0 auto;
    line-height: 40px;

}

.menu-content p {
    margin: 5px 0;
    background-color: #ddd;
    border-radius: 6px;
}

.menu-content p:hover {
    cursor: pointer;
    background-color: #ddd;
    border-radius: 6px;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}

</style>




<div class="menu-popup" id="menuPopup">
        <div class="menu-content">
            <!-- Add your menu content here -->
            <div class="contents">
            <a href="../home/"><p class="menu-agent" >Our Agents</p></a>
            <a href="../home/"><p class="menu-agent" >Our Models</p></a>
            <a href="../home/"><p class="menu-agent" >Search Jobs</p></a>
            </div>
            <!-- Close button -->
            <span class="close" id="closePopup">&times;</span>
        </div>
    </div>

    <div class="sticky-footer">
        <nav>
            <ul>
                <li>
                    <a href="#" id="homeBtn">
                        <div class="menu-item">
                            <i class='bx bx-home'></i>
                            <span>Home</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" id="menuBtn">
                        <div class="menu-item">
                            <i class='bx bx-category'></i>
                            <span>Menu</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" id="accountBtn">
                        <div class="menu-item">
                            <i class='bx bxs-user-circle'></i>
                            <span>Account</span>
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <script>
        document.getElementById('menuBtn').addEventListener('click', function() {
    document.getElementById('menuPopup').style.display = 'block';
});

document.getElementById('closePopup').addEventListener('click', function() {
    document.getElementById('menuPopup').style.display = 'none';
});

    </script>