class Calculette{
        canvas;
        height;
        width;
        text;
        static nCanvas=0;
        constructor(emplacement,defaultText){
            this.text=defaultText;
            this.canvas=Element.createElement("canvas");
            this.canvas.setAttribute("id","calculatriceTi");
            this.canvas.setAttribute("width","100%");
            document.getElementById(emplacement).appendChild(this.canvas);
            this.canvas.setAttribute("height",Math.round(this.canvas.clientWidth*0.75)+"px");
            this.drawBase();
            this.drawText(defaultText);
        }
        resize(){
            this.canvas.setAttribute("height",Math.round(this.canvas.clientWidth*0.75)+"px");
            this.drawBase();
            this.drawText(this.text);
        }
        drawBase(){
            this.width=this.canvas.clientWidth;
            var ctx=this.canvas.getContext("2d");
            ctx.fillStyle="rgb(255,0,0)";
            ctx.fillRect(20,20,100,100);
            

        }
        drawText(text){
            this.text=text;
        }
        clearText(){

        }
}