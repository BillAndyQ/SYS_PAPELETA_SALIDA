<style>
    .window-popUp{
        display: flex;
        flex-direction:column;
        gap:4px;
        position: absolute;
        bottom: 10px;
        right: 10px;
    }
    .popUp{
        border-radius: 5px;
        font-family: "calibri";
        padding: 10px 20px;
        width: 130px;
        font-size: 14px;
    }
    .popUpcorrect{
        background: green;
        color: #fff;
        animation: animationPopUp 8s forwards;
    }
    .popUpalert{
        background: yellow;
        color: #000;
        animation: animationPopUp 8s forwards;
        animation-delay: 4s;
    }
    .popUperror{
        background: red;
        color: #fff;
        animation: animationPopUp 8s forwards;
        animation-delay: 8s;
    }
    @keyframes animationPopUp {
    0% {
        opacity: 1;
    }
    80% {
        opacity: .8;
    }
    100%{
        opacity: 0;
        display: none;
    }
    }
</style>
<?php
$popUps = [];
function popUpCorrect($txt){
    global $popUps;
    $popUps[] = ["correct",$txt];
}
function popUpAlert($txt){
    global $popUps;
    $popUps[] = ["alert",$txt];
}
function popUpError($txt){
    global $popUps;
    $popUps[] = ["error",$txt];
}
function loadPopUp(){
    global $popUps;
    ?><div class="window-popUp"><?php
    try{
        if(count($popUps) != ""){
            foreach ($popUps as $popUp) {
            ?>
                <div class="<?php echo "popUp ". "popUp". $popUp[0] ?>">
                    <?php echo $popUp[1] ?>
                </div>
            <?php
            }
        }
    }catch(Error){
        
    }

    ?></div><?php
}
