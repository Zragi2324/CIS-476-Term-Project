

import React from 'react'
import executeQuery from './connect'


const page = async ()=>{
    const result = await executeQuery("select * from students",[])
    return (
        
    <div>
       <h2>{JSON.stringify(result)}</h2>
      
    </div>
    )}

export default page;
