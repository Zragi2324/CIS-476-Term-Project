import executeQuery from './connect';

const page = async () => {
    // Ensure you handle potential errors when awaiting the execution of the query
    try {
        const result = await executeQuery("select * from students", []);

        // Check if result is an array before mapping
        if (Array.isArray(result) && (result.length > 0) ) {
            return (
                <div>
                    <h1> Mysql with server action in nextjs</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>Student Id</th>
                                <th>Student Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            {result.map(student => (
                                <tr key={student.id}>
                                    <td>{student.id}</td>
                                    <td>{student.name}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            );
        } else {
            // Handle the case when result is not an array
            return <div>No data found</div>;
        }
    } catch (error) {
        // Handle any errors that might occur during the execution of the query
        console.error("Error fetching data:", error);
        return <div>Error fetching data</div>;
    }
};

export default page;
