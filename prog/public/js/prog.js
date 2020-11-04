function clone(obj) {
    return Object.create(
      Object.getPrototypeOf(obj), 
      Object.getOwnPropertyDescriptors(obj) 
    );
}
class ItemProg{
    id;
    name;
    title;
    description;
    author;
    create_at;
    type=1;
    listItems=[];
    contentNav;
    adresse="";
    button;
    parent;
    sousDiv;
    buttonAppend;
    constructor(argumentsTab,parent=null){
        this.parent=parent;
        this.id=argumentsTab[0];
        this.name=argumentsTab[1];
        if(argumentsTab.length == 8 || argumentsTab.length==7){
            this.title=argumentsTab[2];
            this.description=argumentsTab[3];
            this.author=argumentsTab[4];
            this.create_at=argumentsTab[5];
            this.type=argumentsTab[6];
        }
        if(argumentsTab.length==8 || argumentsTab.length==4)argumentsTab[argumentsTab.length-1].forEach(element => {
            this.listItems.push(new ItemProg(element,this));
        },this);
    }
    createNav(){
        this.contentNav=document.createElement("div");
        this.contentNav.setAttribute("class","ml-4");
        this.listItems.forEach(function (element,index){
            this.contentNav.appendChild(element.createButton(index));
        },this);
        if(this.type==1){
            this.buttonAppend=document.createElement("button");
            this.buttonAppend.setAttribute("class","btn btn-success mb-1");
            this.buttonAppend.setAttribute("id","appendButton");
            this.buttonAppend.innerHTML="Ajouter";
            this.buttonAppend.setAttribute("onclick","progAppend=new AppendItemProg(prog"+this.adresse+");");
            this.contentNav.appendChild(this.buttonAppend);
        }  
    }
    createButton(index){
        this.adresse=this.parent.adresse+".listItems["+index+"]";
        this.sousDiv=document.createElement("div");
        this.sousDiv.setAttribute("style","border-left: 2px solid #28a745");
        this.button=document.createElement("button");
        if(this.type==0){
            this.button.setAttribute("class","btn btn-lg btn-info mb-1");
        }else{
            this.button.setAttribute("class","btn btn-lg btn-dark mb-1");
        }
        this.button.setAttribute("onclick","prog"+this.adresse+".createView()");
        this.button.innerHTML=this.name;
        this.sousDiv.appendChild(this.button);
        this.createNav();
        this.sousDiv.appendChild(this.contentNav);
        return this.sousDiv;    
    }
    createView(){
        document.getElementById("cardItem").setAttribute("style","");
        var badge;
        switch(this.type){
            case 0:
                badge='<span class="badge badge-info">Diapo</span>';
                break;
            case 2:
                badge='<span class="badge badge-secondary">Programme</span>';
                break;
        }
        if(this.type == 1){
            document.getElementById("jumbotronCardItem").setAttribute("style","display:none;");
            document.getElementById("TitleSousProg").setAttribute("style","");
        }else{
            document.getElementById("TitleSousProg").setAttribute("style","display:none;");
            document.getElementById("jumbotronCardItem").setAttribute("style","");
            document.getElementById("cardItemTitle").innerHTML=`<u>${this.title}</u> ${badge}`;
            document.getElementById("cardItemTitle").setAttribute("href","");
            document.getElementById("cardItemDecrip").innerHTML=this.description;
            document.getElementById("cardItemFooter").innerHTML=`Créer par <cite title="${this.author}">${this.author}</cite> le ${this.create_at}`;
        }
        document.getElementById("cardItemName").value=this.name;
        document.getElementById("cardItemDelete").setAttribute("onclick","prog"+this.adresse+".delete()");
        document.getElementById("cardItemUpdate").setAttribute("onclick","prog"+this.adresse+".updateName()");
    }
    addSousProgramme(name){
        var item=new ItemProg([-1,name],this);
        this.listItems.push(item);
        this.contentNav.insertBefore(item.createButton(this.listItems.length-1),this.buttonAppend);
    }
    addItem(item,name){
        item.name=name;
        item.parent=this;
        this.listItems.push(item);
        this.contentNav.insertBefore(item.createButton(this.listItems.length-1),this.buttonAppend);
    }
    updateName(){
        this.name=document.getElementById("cardItemName").value;
        sendJson("",`{"idParent":${this.parent.id},"id":${this.id},"type":"${this.type}","name":"${this.name}"}`);
        this.button.innerHTML=this.name;
    }
    delete(){
        sendJson("",`{"idParent":${this.parent.id},"id":${this.id},"type":"${this.type}","name":"${this.name}"}`);
        this.parent.listItems.splice(this.parent.listItems.indexOf(this),1);
        this.parent.contentNav.removeChild(this.sousDiv);
        this.parent.routing();
        document.getElementById("cardItem").setAttribute("style","display:none;");
    }
    routing(){
        this.listItems.forEach(function(element,index){
            element.adresse=this.adresse+".listItems["+index+"]";
            element.button.setAttribute("onclick","prog"+element.adresse+".createView()");
            element.routing();
        },this);
        if(this.buttonAppend!=null)this.buttonAppend.setAttribute("onclick","progAppend=new AppendItemProg(prog"+this.adresse+")");
    }
}
class AppendItemProg{
    parent;
    bodys=[];
    buttons=[];
    idIsFavoris;
    idTempo;
    appendItemCardSelect;
    pageId=0;
    static items=[[new ItemProg([5,"Physique","Physique","description","author","create_at",0]),new ItemProg([5,"SI","SI","description","Antoine ADAM","06/04/2020",0]),new ItemProg([5,"Math","Math","description","author","create_at",0]),],[new ItemProg([5,"SI","SI","description","Antoine ADAM","06/04/2020",0])],[],[]];
    constructor(parent){
        this.parent=parent;
        this.bodys=[document.getElementById("modalAppendItemPageDiapo"),document.getElementById("modalAppendItemPageProg"),document.getElementById("modalAppendItemPageSousProg")];
        this.buttons=[document.getElementById("modalAppendItemButtonDiapo"),document.getElementById("modalAppendItemButtonProg"),document.getElementById("modalAppendItemButtonSousProg")];
        $("#modalAppendItem").modal("show");
    }
    static start(){
        this.createCard(this.items[0],document.getElementById("cardContainerItemsDiapoP"));
        this.createCard(this.items[1],document.getElementById("cardContainerItemsDiapoF"));
        this.createCard(this.items[2],document.getElementById("cardContainerItemsProgP"));
        this.createCard(this.items[3],document.getElementById("cardContainerItemsProgF"));
    }
    static createCard(list,parent){
        if(list.length==0){
            parent.innerHTML='<p class="lead">Il y a aucun élément dans cette liste.</p>';
            return;
        }
        list.forEach(function(item,index){
            var div=document.createElement("div");
            div.setAttribute("class","card mb-1");
            div.setAttribute("id","appendItemCard");
            div.setAttribute("style","min-width:350px;")
            var divBody=document.createElement("div");
            divBody.setAttribute("class","card-body");
            var title=document.createElement("h5");
            title.setAttribute("class","card-title");
            title.innerHTML=item.title+` <button onclick="progAppend.selectCard(${index},${parent.getAttribute("isFavoris")},this)" class="btn badge badge-success">Sélectionner</button>`;
            var subTitle=document.createElement("h6");
            subTitle.setAttribute("class","blockquote-footer mb-0 text-right");
            subTitle.innerHTML=`Créer par <cite title="${item.author}">${item.author}</cite>, le ${item.create_at}`;
            var desc=document.createElement("p");
            desc.setAttribute("class","card-text")
            desc.innerHTML=item.description+`<a href="/${item.type==0?"diapo":"programme"}/${item.id}" class="badge badge-primary">Voir Plus</a>`;
            this.appendChild(div);
            div.appendChild(divBody);
            divBody.appendChild(title);
            divBody.appendChild(desc);
            divBody.appendChild(subTitle);
        },parent);
    }
    reset(){
        this.idIsFavoris=null;
        this.idTempo=null;
        if(this.appendItemCardSelect!=null)this.appendItemCardSelect.setAttribute("class","card mb-1");
    }
    resetAll(){
        this.switchPage(0);
        document.getElementById("nameItemAppend").value="";
    }
    selectCard(index,isFavoris,parent){
        this.idIsFavoris=isFavoris;
        this.idTempo=index;
        if(this.appendItemCardSelect!=null)this.appendItemCardSelect.setAttribute("class","card mb-1");
        this.appendItemCardSelect=parent.parentElement.parentElement.parentElement;
        this.appendItemCardSelect.setAttribute("class","card mb-1 bg-success");
    }
    create(){
        var name=document.getElementById("nameItemAppend");
        if(this.pageId==2){
            sendJson("",`{"idParent":${this.parent.id},"name":"${name.value}"}`);
            this.parent.addSousProgramme(name.value);
        }else{
            if(this.idTempo==null)return;
            var indexTab=(this.pageId==0)?0:2;
            if(this.isFavoris)indexTab++;
            var item=clone(AppendItemProg.items[indexTab][this.idTempo]);
            sendJson("",`{"idParent":${this.parent.id},"id":${item.id},"type":"${item.type}","name":"${name.value}"}`);
            this.parent.addItem(item,name.value);
        }
        $("#modalAppendItem").modal("hide");
    }
    switchPage(id){
        this.reset();
        this.pageId=id;
        var span="Nom du ";
        switch(id){
            case 0:
                span+="diapo";
                break;
            case 1:
                span+="programme";
                break;
            case 2:
                span+="sous-programme";
                break;
        }
        document.getElementById("nameItemAppendSpan").innerHTML=span+":";
        this.buttons.forEach(function(b,index){
            if(index==this.pageId){
                b.setAttribute("disabled","");
                this.bodys[index].setAttribute("style","");
            }else{
                b.removeAttribute("disabled");
                this.bodys[index].setAttribute("style","display:none;");
            }
        },this);
    }
}
function sendJson(path,json){
    var XHR = new XMLHttpRequest();
    var FD  = new FormData();
    FD.append("dataJson", json);
    XHR.addEventListener('load', function(event) {

    });
    XHR.addEventListener('error', function(event) {

    });
    XHR.onreadystatechange = function() {
        if (XHR.readyState === 4) {
            //action
        }
    }
    XHR.open('POST', path);
    XHR.send(FD);
}
var prog;
var progAppend;
window.addEventListener("load", function(event) {
    prog=new ItemProg([5,"name","title","description","author","create_at",1,
    [[5,"Math","title","description","author","create_at",1,[[5,"Intégral","title","description","author","create_at",0,],[5,"Statistique","title","description","author","create_at",0,]]],
    [5,"Physique","title","description","author","create_at",0],
    [5,"SI","title","description","author","create_at",1,[[5,"Mouvement","title","description","author","create_at",1,[[5,"Statique","title","description","author","create_at",0,[]],[5,"Dinamique","title","description","author","create_at",0,[]]]],[5,"Torseur","title","description","author","create_at",0,[]]]]]]);
    prog.createNav();
    document.getElementById("contenue").appendChild(prog.contentNav);
    AppendItemProg.start();
});