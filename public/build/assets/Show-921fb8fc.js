import{_ as c}from"./AppLayout-2ea5157a.js";import p from"./DeleteUserForm-6eda679d.js";import l from"./LogoutOtherBrowserSessionsForm-4ce11817.js";import{S as s}from"./SectionBorder-64c5ad54.js";import f from"./TwoFactorAuthenticationForm-5b5aad41.js";import u from"./UpdatePasswordForm-fc5cadb4.js";import d from"./UpdateProfileInformationForm-08558eed.js";import{o,c as _,w as n,a as i,d as r,b as t,e as a,F as h}from"./app-6368ce4f.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./DialogModal-c82ebe13.js";import"./SectionTitle-092bc91c.js";import"./Modal-ae5f0b75.js";import"./DangerButton-0cc73a6b.js";import"./TextInput-e3edec0e.js";import"./SecondaryButton-0f744ae6.js";import"./ActionMessage-a178626e.js";import"./PrimaryButton-66494774.js";import"./InputLabel-19a6c087.js";import"./FormSection-288bcb1b.js";const g=i("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Profile ",-1),$={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},w={key:0},k={key:1},y={key:2},G={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array},setup(m){return(e,x)=>(o(),_(c,{title:"Profile"},{header:n(()=>[g]),default:n(()=>[i("div",null,[i("div",$,[e.$page.props.jetstream.canUpdateProfileInformation?(o(),r("div",w,[t(d,{user:e.$page.props.auth.user},null,8,["user"]),t(s)])):a("",!0),e.$page.props.jetstream.canUpdatePassword?(o(),r("div",k,[t(u,{class:"mt-10 sm:mt-0"}),t(s)])):a("",!0),e.$page.props.jetstream.canManageTwoFactorAuthentication?(o(),r("div",y,[t(f,{"requires-confirmation":m.confirmsTwoFactorAuthentication,class:"mt-10 sm:mt-0"},null,8,["requires-confirmation"]),t(s)])):a("",!0),t(l,{sessions:m.sessions,class:"mt-10 sm:mt-0"},null,8,["sessions"]),e.$page.props.jetstream.hasAccountDeletionFeatures?(o(),r(h,{key:3},[t(s),t(p,{class:"mt-10 sm:mt-0"})],64)):a("",!0)])])]),_:1}))}};export{G as default};
