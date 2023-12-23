import { boot } from 'quasar/wrappers'

export default boot(({ app }) => {
  if(process.env.DEV) {
    app.config.globalProperties.$_pathAPI = '/fhcore/api'
    app.config.globalProperties.$_pathWeb = '/fhcore'
  }
  else {
    app.config.globalProperties.$_pathAPI = '/fhcore/public/api'
    app.config.globalProperties.$_pathWeb = '/fhcore/public'
  }
})
