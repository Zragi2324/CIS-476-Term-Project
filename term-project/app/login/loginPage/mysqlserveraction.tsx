import { Form } from "formik";
import executeQuery from "@/app/api/connectApi/connect";
import Link from "next/link";



const  Mysqlserveraction = async (formData: FormData) =>{
    'use server' // only exeuting on th server only 


    const currentFormData = {
        userId: formData.get('id'),
        userName: formData.get('name'),
        status: formData.get('status'),
    }

    try {
        const result = await executeQuery("select * from students where id=? and username=?", [currentFormData.userId, currentFormData.userName]);

        // Check if result is an array before mapping
        if (Array.isArray(result) && (result.length > 0) ) {
            return (
            <>
            <Link href="@/app/welcome"></Link>
            <form action ={Mysqlserveraction}>...</form>
            </>)
        }}
        catch(error){
          console.log(error)
          return error
        }
};

export default Mysqlserveraction;


