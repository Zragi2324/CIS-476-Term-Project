'use client';

import React from 'react';
import { useFormState, useFormStatus } from 'react-dom';
import Mysqlserveraction from './mysqlserveraction';

/*
const initalState = {
    message : null,

};*/
const ModifyStudent =()=>{
    
const {pending} = useFormState();
const {state,formAction} = useFormState(Mysqlserveraction, initalState);
    return(
        <div>
            <form method ="post" action = {formAction} >
                <input type="text" id="id" placeholder="id" value = {userName} onChange= {(e) => setUserName(e.target.value)} ></input>
                <input type="text" id="name" placeholder="name" value = {password} onChange= {(e) => setPassword(e.target.value)}></input>
                <button type="submit" id="submit">Submit {pending? "Insertnig...":"Insert"}</button><br />
                
            </form>
        </div>
    )
}


//export default ModifyStudent;