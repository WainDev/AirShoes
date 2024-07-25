<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бренды</title>
    <link rel="stylesheet" href="./Assets/styles/style.css">
    <style>
        #myCarousel {
            margin-top: 50px;
        }

        @media (max-width: 768px) {
            .carousel-inner .carousel-item>div {
                display: none;
            }

            .carousel-inner .carousel-item>div:first-child {
                display: block;
            }
        }

        .carousel-inner .carousel-item.active,
        .carousel-inner .carousel-item-start,
        .carousel-inner .carousel-item-next,
        .carousel-inner .carousel-item-prev {
            display: flex;
        }

        @media (min-width: 768px) {

            .carousel-inner .carousel-item-right.active,
            .carousel-inner .carousel-item-next,
            .carousel-item-next:not(.carousel-item-start) {
                transform: translateX(25%) !important;
            }

            .carousel-inner .carousel-item-left.active,
            .carousel-item-prev:not(.carousel-item-end),
            .active.carousel-item-start,
            .carousel-item-prev:not(.carousel-item-end) {
                transform: translateX(-25%) !important;
            }

            .carousel-item-next.carousel-item-start,
            .active.carousel-item-end {
                transform: translateX(0) !important;
            }

            .carousel-inner .carousel-item-prev,
            .carousel-item-prev:not(.carousel-item-end) {
                transform: translateX(-25%) !important;
            }
        }
    </style>
    <script type="text/javascript" src="./Scripts/popper.min.js"></script>
</head>

<body oncontextmenu="return false" class="snippet-body">
    <link href="./Assets/styles/bootstrap.min.css" rel="stylesheet" />
    <script src="./Scripts/bootstrap.bundle.min.js"></script>
    <h2 class="title__brends">Бренды</h2>
    <div id="myCarousel" class="carousel slide container" data-bs-ride="carousel">
        <div class="carousel-inner  w-100">
            <?php
            include_once "Config/Database.php";
            $db = new Database();
            $conn = $db->getConnection();
            if ($conn) {
                $query = "SELECT * FROM Brands";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $conn = null;
                foreach ($products as $product) {
            ?>
                    <div class="carousel-item active">
                        <div class="col-md-3">
                            <div class="card card-body ">
                                <a class="img__brends" href="brends_list.php?id=<?php echo $product['Id']; ?>">
                                    <img class="img-fluid" src="<?php echo $product['ImgUrl']; ?>" />
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "Ошибка соединения с базой данных";
            }
            ?>
        </div>
        <button class="carousel-control-prev carousel-control-prev-black " type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon " aria-hidden="true"></span>
            <span class="visually-hidden ">Previous</span>
        </button>
        <button class="carousel-control-next carousel-control-next-black " type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon " aria-hidden="true"></span>
            <span class="visually-hidden ">Next</span>
        </button>
    </div>
    <script src="./Scripts/jquery.min.js"></script>
    <script type="text/javascript">
        $(".carousel .carousel-item").each(function() {
            var minPerSlide = 4;
            var next = $(this).next();
            if (!next.length) {
                next = $(this).siblings(":first");
            }
            next.children(":first-child").clone().appendTo($(this));

            for (var i = 0; i < minPerSlide; i++) {
                next = next.next();
                if (!next.length) {
                    next = $(this).siblings(":first");
                }
                next.children(":first-child").clone().appendTo($(this));
            }
        });
    </script>
</body>

</html>