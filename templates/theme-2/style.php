<style>
body {
    margin: auto;
    color: <?php echo $vendor["websiteColor"] ?>;
    font-weight: 700;
}

::-webkit-scrollbar {
    width: 5px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb {
    border-radius: 5px;
    background-color: <?php echo $vendor["websiteColor"] ?>;
}

#leftSide {
    /*height: 100vh;
    overflow-y: scroll;*/
}

#rightSide {
    height: 100vh;
    overflow-y: hidden;
    position: relative;
}

.logo {
    display: block;
    margin: 0 auto;
    width: 150px;
    height: 150px;
}

.logoBg {
    background-color: #FFFFFF;
    width: 250px;
    height: 250px;
    position: absolute;
    top: 15%;
    left: 50%;
    transform: translate(-50%, 50%);
    border-radius: 100%;
}

.bgOver {
    background-color: rgba(0, 0, 0, 0.7);
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
}

.poweredByRight {
    position: absolute;
    bottom: 25px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    border-radius: 100%;
}

.heroLogo {
    display: block;
    margin: 0 auto;
    width: 70px;
    height: 70px;
}

.heroLogoBg {
    background-color: #FFFFFF;
    width: 125px;
    height: 125px;
    position: relative;
    bottom: 20px;
    left: 50%;
    /*transform: translate(-50%, 50%);*/
    border-radius: 100%;
}

.headerClass {
    box-sizing: border-box;
    box-shadow: 0px 2px 0px #e9e9e9;
}

.socialMediaBar {
    box-sizing: border-box;
    box-shadow: 0px 0px 10px #d2cece;
}

input {
    margin-top: 10px;
    margin-bottom: 10px;
    border-radius: 0px !important;
}

select {
    margin-top: 10px;
    margin-bottom: 10px;
    border-radius: 0px !important;
}

button {
    border-radius: 0px !important;
}

.btnPrice {
    font-size: 10px;
    font-weight: 500;
}

.serviceBLk {
    border: 1px solid <?php echo $vendor["websiteColor"] ?>;
    border-radius: 0px !important;
}

.serviceBLk:hover {
    background-color: <?php echo $vendor["websiteColor"] ?>;
    color: white;
}

.activeService {
    background-color: <?php echo $vendor["websiteColor"] ?>;
    color: white;
}

.socialMediaSpan {
    border: 2px <?php echo $vendor["websiteColor"] ?> solid;
    padding-right: 8px;
    padding-left: 8px;
    color: <?php echo $vendor["websiteColor"] ?>;
}

.btn {
    background-color: <?php echo $vendor["websiteColor"] ?>;
    border: 1px solid <?php echo $vendor["websiteColor"] ?>;
}

.btn:hover {
    -webkit-box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.5);
    box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.5);
    background-color: <?php echo $vendor["websiteColor"] ?>;
    border: 1px solid <?php echo $vendor["websiteColor"] ?>;
}

.socialMediaSpan:hover {
    background-color: <?php echo $vendor["websiteColor"] ?>;
    color: white;
}

.poweredMobile {
    width: 25px;
    height: 25px;
    border-radius: 100%;
}

.successBody {
    box-sizing: border-box;
    box-shadow: 0px 0px 10px #d2cece;
}

.successInfoSection {
    border: 2px solid <?php echo $vendor["websiteColor"] ?>;
    color: <?php echo $vendor["websiteColor"] ?>;
}
.rightBg {
    background-image: url("logos/<?php echo $vendor["coverImg"] ?>");
    background-size: cover;
    background-position: center;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
}

.heroBg {
    -webkit-box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.7);
    box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.25);
    background-image: url("logos/<?php echo $vendor["coverImg"] ?>");
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    height: 200px;
}
#loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.7);
    z-index: 1000;
    display: none;
}

#loading-screen img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}
</style>