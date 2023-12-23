import { boot } from 'quasar/wrappers'

export default boot(({ app }) => {
  if(process.env.DEV) {
    app.config.globalProperties.$_pathAPI = '/ckcore/api'
    app.config.globalProperties.$_pathWeb = '/ckcore'
  }
  else {
    app.config.globalProperties.$_pathAPI = '/ckcore/public/api'
    app.config.globalProperties.$_pathWeb = '/ckcore/public'
  }
})
