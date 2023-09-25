<form action="../job_search_results/" method="GET">
        <div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
            <div class="container">
                <div class="row g-2">
                    <div class="col-md-10">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="keyword" class="form-control border-0" placeholder="Keyword" />
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-select border-0">
                                    <option selected>Category</option>
                                    <?php
                                    // Connect to your database (replace with your database connection code)
                                   include('../../assets/setup/db.php');

                                    // Fetch categories from the database
                                    $category_query = "SELECT DISTINCT job_category FROM jobs";
                                    $category_result = $conn->query($category_query);

                                    if ($category_result->num_rows > 0) {
                                        while ($row = $category_result->fetch_assoc()) {
                                            echo '<option value="' . $row["job_category"] . '">' . $row["job_category"] . '</option>';
                                        }
                                    }

                                    //$conn->close();
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="location" class="form-select border-0">
                                    <option selected>Location</option>
                                    <?php
                                    // Connect to your database (replace with your database connection code)
                                    include('../../assets/setup/db.php');

                                    // Fetch locations from the database
                                    $location_query = "SELECT DISTINCT job_location FROM jobs";
                                    $location_result = $conn->query($location_query);

                                    if ($location_result->num_rows > 0) {
                                        while ($row = $location_result->fetch_assoc()) {
                                            echo '<option value="' . $row["job_location"] . '">' . $row["job_location"] . '</option>';
                                        }
                                    }

                                    //$conn->close();
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark border-0 w-100">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>