import{i as u,q as c,o as t,f as s,b as d,t as l,r as m,B as p,p as _,l as f,C as g}from"./app-DQeq4vfr.js";const v={class:"text-sm text-red-600"},S={__name:"InputError",props:{message:{type:String}},setup(e){return(a,o)=>u((t(),s("div",null,[d("p",v,l(e.message),1)],512)),[[c,e.message]])}},x={class:"block font-medium text-sm text-gray-700"},h={key:0},y={key:1},V={__name:"InputLabel",props:{value:{type:String}},setup(e){return(a,o)=>(t(),s("label",x,[e.value?(t(),s("span",h,l(e.value),1)):(t(),s("span",y,[m(a.$slots,"default")]))]))}},B={__name:"TextInput",props:{modelValue:{type:String,required:!0},modelModifiers:{}},emits:["update:modelValue"],setup(e,{expose:a}){const o=p(e,"modelValue"),n=_(null);return f(()=>{n.value.hasAttribute("autofocus")&&n.value.focus()}),a({focus:()=>n.value.focus()}),(b,r)=>u((t(),s("input",{class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm","onUpdate:modelValue":r[0]||(r[0]=i=>o.value=i),ref_key:"input",ref:n},null,512)),[[g,o.value]])}};export{V as _,B as a,S as b};
