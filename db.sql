CREATE TABLE CLIENTS (
    client_id INT PRIMARY KEY,
    client_name VARCHAR(100),
    discount DECIMAL(5,2)
);

CREATE TABLE AGENTS (
    agent_id INT PRIMARY KEY,
    agent_name VARCHAR(100),
    commission DECIMAL(5,2)
);

CREATE TABLE INSURANCE (
    insurance_id INT PRIMARY KEY,
    insurance_name VARCHAR(100),
    tariff DECIMAL(5,2)
);

CREATE TABLE CONTRACTS (
    contract_id INT PRIMARY KEY,
    client_id INT,
    agent_id INT,
    insurance_amount DECIMAL(10,2),
    insurance_id INT,
    contract_date DATE,
    FOREIGN KEY (client_id) REFERENCES CLIENTS (client_id),
    FOREIGN KEY (agent_id) REFERENCES AGENTS (agent_id),
    FOREIGN KEY (insurance_id) REFERENCES INSURANCE (insurance_id)
);
