import React, {Component} from "react";
import axios from "axios";
import {Modal, Button} from 'react-bootstrap';
import {BASE_URL} from "../config";

const styles = {
    fontFamily: "sans-serif",
    textAlign: "center"
};

class Home extends Component {
    constructor(props) {
        super(props);
        //let { user } = this.props.appstate;
        this.handleShow = this.handleShow.bind(this);
        this.handleClose = this.handleClose.bind(this);
        this.handlePdfShow = this.handlePdfShow.bind(this);
        this.handlePdfClose = this.handlePdfClose.bind(this);
        this.handleSelectedFile = this.handleSelectedFile.bind(this);
        this.handleUpload = this.handleUpload.bind(this);
        this.state = {
            token: localStorage["appState"]
                ? JSON.parse(localStorage["appState"]).user.auth_token
                : "",
            documents: [],
            show: false,
            showPdfModal: false,
            selectedFile: null,
            loaded: 0,
            pdfUrl: null
        };
    }

    componentDidMount() {
        axios.get(`${BASE_URL}documents`, {
                headers: {
                    "Authorization": `Bearer ${this.state.token}`
                }
            })
            .then(response => {
                console.log(response);
                return response;
            })
            .then(json => {
                if (json.data) {
                    this.setState({documents: json.data.data});
                } else alert("Login Failed!");
            })
            .catch(error => {
                console.error(`An Error Occuredd! ${error}`);
            });
    }

    handleGetDocument(id) {
        axios.get(`${BASE_URL}documents/${id}`, {
            headers: {
                "Authorization": `Bearer ${this.state.token}`
            }
        })
            .then(response => {
                console.log(response);
                return response;
            })
            .then(json => {
                if (json.data) {
                    let doc = this.state.documents;
                    doc.push(json.data)
                    this.setState({documents: doc});
                } else alert("Login Failed!");
            })
            .catch(error => {
                console.error(`An Error Occuredd! ${error}`);
            });
    }

    handleSelectedFile(event) {
        this.setState({
            selectedFile: event.target.files[0],
            loaded: 0,
        })
    }

    handleUpload() {
        const data = new FormData()
        data.append('file', this.state.selectedFile, this.state.selectedFile.name)

        axios
            .post(`${BASE_URL}documents`, data, {
                headers: {
                    "Authorization": `Bearer ${this.state.token}`
                },
                onUploadProgress: ProgressEvent => {
                    this.setState({
                        loaded: (ProgressEvent.loaded / ProgressEvent.total * 100),
                    });
                },
            })
            .then(response => {
                console.log(response)
                this.handleGetDocument(response.data.id);
                this.handleClose();
            })

    }

    handleClose() {
        this.setState({show: false});
    }

    handleShow() {
        this.setState({show: true});
    }

    handlePdfShow(obj) {
        console.log(obj);
        this.setState({showPdfModal: true, pdfUrl: obj.file});
    }

    handlePdfClose() {
        this.setState({showPdfModal: false});
    }

    render() {
        return (
            <div style={styles}>
                <h2>Welcome Home {"\u2728"}</h2>
                <p>List of all documents on the system</p>
                <Button variant="primary" onClick={this.handleShow}>
                    Upload Document
                </Button>
                <Modal show={this.state.show} onHide={this.handleClose}>
                    <Modal.Header closeButton>
                        <Modal.Title>Modal heading</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <input type="file" name="" accept=".pdf" onChange={this.handleSelectedFile}/>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="secondary" onClick={this.handleClose}>
                            Close
                        </Button>
                        <Button variant="primary" onClick={this.handleUpload}>
                            Upload
                        </Button>
                    </Modal.Footer>
                </Modal>
                <Modal show={this.state.showPdfModal} onHide={this.handlePdfClose}>
                    <Modal.Header closeButton>
                        <Modal.Title>Modal heading</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <iframe src={this.state.pdfUrl} width="100%" height="500">No Support
                        </iframe>
                    </Modal.Body>
                </Modal>
                <ul>
                    {this.state.documents.map(doc => (
                        <li
                            style={{
                                padding: 15,
                                border: "1px solid #cccccc",
                                width: 250,
                                textAlign: "left",
                                marginBottom: 15,
                                marginLeft: "auto",
                                marginRight: "auto",
                                listStyle: "none",
                                float: "left"
                            }}
                        >
                            <img src={doc.image} onClick={() => {
                                this.handlePdfShow(doc)
                            }} width="100"/>
                        </li>
                    ))}
                </ul>
                <button
                    style={{padding: 10, backgroundColor: "red", color: "white"}}
                    onClick={this.props.logoutUser}
                >
                    Logout{" "}
                </button>
            </div>
        );
    }
}

export default Home;