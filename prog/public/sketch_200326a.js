let font;
function preload(){
    font=loadFont("ti.ttf");
}
function setup() {
    print(windowWidth+"|"+windowHeight);
    if(windowHeight==0)return;
    let format=windowHeight/windowWidth;
    if(format<0.75)
        createCanvas(windowWidth/(0.75/format), windowHeight);
    else
        createCanvas(windowWidth, windowHeight/(format/0.75));
    textFont(font);
    textSize(height/17.5);
    print(height/40);
    textAlign(LEFT, TOP);
    ecran();
}
function update(texte){
    print(texte);
    clearScrenn();
    textDraw(texte);
}

function clearScrenn(){
    fill(255,255,255);
    rect(0.0875*width,0.2*height,width*0.83,height*0.68);
}
function textDraw(dataText){
    let i=dataText.length;
    let ref=i;
    let repere=0
    fill("black");
    while(true){
        i-=33;
        if(i>0){
            text(dataText.slice(ref-i-33,ref-i),width*0.0875,height*(0.21+0.05*repere));
            print(dataText.slice(ref-i-33,ref-i));
        }else{
            text(dataText.slice(ref-i-33,ref),width*0.0875,height*(0.21+0.05*repere));
            break;
        }
        if(repere == 12)break;
        repere++;
    }
}

function ecran(){
    noStroke();
    fill(230,226,230);
    rect(0,0,width,height);
    fill(82,85,82);
    rect(0,0,width,height*0.14);
    fill(255,255,255);
    rect(0.0875*width,0.2*height,width*0.83,height*0.68);
    //pile
    fill(183,181,183);
    rect(0.95*width,0.028*height,0.046*width,0.078*height);
    rect(width*0.963,height*0.0167,width*0.021,height*0.0167)
    fill(255,255,255);
    rect(width*0.959,height*0.033,width*0.029,height*0.067);
    fill(0,159,0);
    rect(width*0.963,height*0.033,width*0.021,height*0.067);
    //text
    fill(255,255,255);
    text("NORMAL FLOTT AUTO RÉEL DEGRÉ MP",0,0);
    fill("grey");
    text("TI-83 Premium CE",width*0.3,height*0.08);
    text("©antoineadam.fr",width*0.31,height*0.92);
}