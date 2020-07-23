(this["webpackJsonpdva-boot-admin"]=this["webpackJsonpdva-boot-admin"]||[]).push([[12],{1012:function(e,a,t){},1134:function(e,a,t){"use strict";t.r(a);var r,s=t(32),n=t(14),o=t(15),l=t(20),i=t(19),c=t(0),m=t.n(c),d=t(30),u=t(88),g=t(416),f=t(1126),p=t(819),h=t(926),v=t(1130),E=t(1117),w=t(826),P=t(821),b=t(822),M=t(191),y=t(817),S=t(6),C=t.n(S),k=t(31),T=t(152),j="routes.Register",F={titleSignUp:{id:"".concat(j,".titleSignUp"),defaultMessage:"Sign Up To Admin Panel"},email:{id:"".concat(j,".email"),defaultMessage:"Email"},messageEmail:{id:"".concat(j,".messageEmail"),defaultMessage:"Please enter your email address."},messageEmailFormat:{id:"".concat(j,".messageEmailFormat"),defaultMessage:"Incorrect email address format."},checkPassword:{id:"".concat(j,".checkPassword"),defaultMessage:"Please enter at least 6 characters. Please do not use passwords that are easy to guess."},placeholderPassword:{id:"".concat(j,".placeholderPassword"),defaultMessage:"At least 6 passwords, case sensitive"},enterPassword:{id:"".concat(j,".enterPassword"),defaultMessage:"Please confirm your password!"},passwordsTwice:{id:"".concat(j,".passwordsTwice"),defaultMessage:"The passwords entered twice do not match!"},confirmPassword:{id:"".concat(j,".confirmPassword"),defaultMessage:"Confirm Password"},enterPhone:{id:"".concat(j,".enterPhone"),defaultMessage:"Please enter phone number!"},placeholderPhone:{id:"".concat(j,".placeholderPhone"),defaultMessage:"11-digit mobile phone number"},enterCode:{id:"".concat(j,".enterCode"),defaultMessage:"Please enter verification code!"},placeholderCode:{id:"".concat(j,".placeholderCode"),defaultMessage:"Verification code"},getCode:{id:"".concat(j,".getCode"),defaultMessage:"Get code"},cancel:{id:"".concat(j,".cancel"),defaultMessage:"Cancel"},signUp:{id:"".concat(j,".signUp"),defaultMessage:"Sign Up"},LoginNow:{id:"".concat(j,".LoginNow"),defaultMessage:"Sign in with an existing account"},viewMailbox:{id:"".concat(j,".viewMailbox"),defaultMessage:"View mailbox"},backToHome:{id:"".concat(j,".backToHome"),defaultMessage:"Back to home"},registrationSuccess:{id:"".concat(j,".registrationSuccess"),defaultMessage:"Registration Success"},textRegister:{id:"".concat(j,".textRegister"),defaultMessage:"The activation email has been sent to your email address and is valid for 24 hours. Please log in to the email in time and click on the link in the email to activate the account."}},N=g.a.Content,x=function(e){Object(l.a)(t,e);var a=Object(i.a)(t);function t(){return Object(n.a)(this,t),a.apply(this,arguments)}return Object(o.a)(t,[{key:"render",value:function(){var e=m.a.createElement(c.Fragment,null,m.a.createElement(M.a,{type:"primary"},C.a.formatMessage(F.viewMailbox)),m.a.createElement(M.a,{href:"/"},C.a.formatMessage(F.backToHome))),a=m.a.createElement(c.Fragment,null,m.a.createElement("p",null,m.a.createElement("span",null,"Need More Help?")),m.a.createElement("p",null,"Misc question two? ",m.a.createElement("span",null,"Response Link"))),t=m.a.createElement("div",null,"Yoursite.com");return m.a.createElement(g.a,{className:"full-layout result-page"},m.a.createElement(N,null,m.a.createElement(T.d,{title:C.a.formatMessage(F.registrationSuccess),type:"success",actions:e,footer:a,extra:t},C.a.formatMessage(F.textRegister))))}}]),t}(c.Component),B=t(150),O=t.n(B),I=(t(1012),t(867),d.c.Link),U=g.a.Content,L=f.a.Item,R=p.a.Option,V=h.a.Group,q=v.a.Title,D={ok:m.a.createElement("div",{style:{color:"#52c41a"}},"Strength: Strong"),pass:m.a.createElement("div",{style:{color:"#faad14"}},"Strength: Medium"),poor:m.a.createElement("div",{style:{color:"#f5222d"}},"Strength: Too Short")},G={ok:"success",pass:"normal",poor:"exception"},H=Object(u.c)((function(e){return{register:e.register,submitting:e.loading.effects["register/submit"]}}))(r=function(e){Object(l.a)(t,e);var a=Object(i.a)(t);function t(e){var r;return Object(n.a)(this,t),(r=a.call(this,e)).onGetCaptcha=function(){var e=59;r.setState({count:e}),r.interval=setInterval((function(){e-=1,r.setState({count:e}),0===e&&clearInterval(r.interval)}),1e3)},r.getPasswordStatus=function(){var e=r.refs.form;if(e){var a=e.getFieldValue("password");if(a&&a.length>9)return"ok";if(a&&a.length>5)return"pass"}return"poor"},r.handleSubmit=function(e){var a=r.props.dispatch;r.setState({visible:!1}),a({type:"register/submit",payload:Object(s.a)({},e)})},r.handleConfirmBlur=function(e){var a=e.target.value,t=r.state.confirmDirty;r.setState({confirmDirty:t||!!a})},r.checkConfirm=function(e,a){return e&&e!==a("password")?Promise.reject(C.a.formatMessage(F.passwordsTwice)):Promise.resolve()},r.checkPassword=function(e,a){if(!e)return r.setState({visible:!!e}),Promise.reject(C.a.formatMessage(F.enterPassword));var t=r.state,s=t.visible,n=t.confirmDirty;return s||r.setState({visible:!!e}),e.length<6?Promise.reject(C.a.formatMessage(F.placeholderPassword)):(e&&n&&a(["confirm"],{force:!0}),Promise.resolve())},r.renderPasswordProgress=function(){var e=r.refs.form,a=r.getPasswordStatus();if(e){var t=e.getFieldValue("password");return t&&t.length?m.a.createElement(E.a,{status:G[a],className:"progress-".concat(a),strokeWidth:6,percent:10*t.length>100?100:10*t.length,showInfo:!1}):null}return null},r.state={count:0,confirmDirty:!1,visible:!1,registerSuccess:!1},r}return Object(o.a)(t,[{key:"componentWillUnmount",value:function(){clearInterval(this.interval)}},{key:"render",value:function(){var e=this,a=this.props.submitting,t=this.state,r=t.count,s=t.visible;return t.registerSuccess?m.a.createElement(x,null):m.a.createElement(g.a,{className:"full-layout register-page login-page"},m.a.createElement(U,null,m.a.createElement(f.a,{onFinish:this.handleSubmit,scrollToFirstError:!0,ref:"form",name:"basic",className:"login-form",initialValues:{prefix:"86"}},m.a.createElement("div",{className:"user-img"},m.a.createElement("img",{src:O.a,alt:"logo"})),m.a.createElement(q,{level:4,className:"text-center"},C.a.formatMessage(F.titleSignUp)),m.a.createElement(L,{name:"mail",rules:[{required:!0,message:C.a.formatMessage(F.messageEmail)},{type:"email",message:C.a.formatMessage(F.messageEmailFormat)}],validateTrigger:["onChange","onBlur"]},m.a.createElement(h.a,{placeholder:C.a.formatMessage(F.email)})),m.a.createElement(w.a,{overlayClassName:"popover-register-page",content:m.a.createElement("div",{style:{padding:"4px 0"}},D[this.getPasswordStatus()],this.renderPasswordProgress(),m.a.createElement("div",{style:{marginTop:10}},C.a.formatMessage(F.checkPassword))),overlayStyle:{width:240},placement:"right",visible:s},m.a.createElement(L,{name:"password",rules:[function(a){var t=a.validateFields,r=e.checkPassword;return{validator:function(e,a){return r(a,t)}}}],validateTrigger:["onChange","onBlur"],hasFeedback:!0},m.a.createElement(h.a.Password,{type:"password",placeholder:C.a.formatMessage(F.placeholderPassword),onChange:function(){return e.setState({visible:!0})},onBlur:function(){return e.setState({visible:!1})},onFocus:function(){return e.setState({visible:!0})}}))),m.a.createElement(L,{name:"confirm",rules:[{required:!0,message:C.a.formatMessage(F.enterPassword)},function(e){var a=e.getFieldValue;return{validator:function(e,t){return t&&t!==a("password")?Promise.reject(C.a.formatMessage(F.passwordsTwice)):Promise.resolve()}}}],validateTrigger:["onChange","onBlur"],hasFeedback:!0},m.a.createElement(h.a.Password,{type:"password",placeholder:C.a.formatMessage(F.confirmPassword),onBlur:this.handleConfirmBlur})),m.a.createElement(V,{compact:!0},m.a.createElement(L,{name:"mobile",rules:[{required:!0,message:C.a.formatMessage(F.enterPhone)}],style:{width:"100%"},validateTrigger:["onChange","onBlur"]},m.a.createElement(h.a,{addonBefore:m.a.createElement(f.a.Item,{name:"prefix",noStyle:!0},m.a.createElement(p.a,null,m.a.createElement(R,{value:"86"},"+86"),m.a.createElement(R,{value:"87"},"+87"))),placeholder:C.a.formatMessage(F.placeholderPhone)}))),m.a.createElement(L,{name:"captcha",rules:[{required:!0,message:C.a.formatMessage(F.enterCode)}],validateTrigger:["onChange","onBlur"]},m.a.createElement(P.a,{gutter:8},m.a.createElement(b.a,{span:16},m.a.createElement(h.a,{placeholder:C.a.formatMessage(F.placeholderCode)})),m.a.createElement(b.a,{span:8},m.a.createElement(M.a,{className:"getCaptcha",disabled:r,onClick:this.onGetCaptcha},r?"".concat(r," s"):C.a.formatMessage(F.getCode))))),m.a.createElement(f.a.Item,{name:"agreement",valuePropName:"checked",rules:[{validator:function(e,a){return a?Promise.resolve():Promise.reject("Should accept agreement")}}],validateTrigger:["onChange","onBlur"]},m.a.createElement(y.a,null,"I have read the agreement")),m.a.createElement(P.a,{align:"center",className:"mb-2"},m.a.createElement(M.a,{loading:a,size:"large",type:"primary",htmlType:"submit",className:"register-form-button"},C.a.formatMessage(F.signUp))),m.a.createElement(P.a,{align:"center"},m.a.createElement(I,{to:Object(k.a)("Login")},C.a.formatMessage(F.LoginNow))))))}}],[{key:"getDerivedStateFromProps",value:function(e,a){return e.register.status?{registerSuccess:!0}:null}}]),t}(c.Component))||r;a.default=H},867:function(e,a,t){}}]);
//# sourceMappingURL=12.c58d279b.chunk.js.map