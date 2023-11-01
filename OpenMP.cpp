#include <iostream>
#include <fstream>
#include <vector>
#include <sstream>
#include <omp.h>
#include <string>

// Number of rooms, seats per room, students, and departments
const int numRooms = 2;        // Number of rooms
const int maxSeatsPerRoom = 60; // Maximum seats per room
const int numStudents = 100;
const int maxStudentsPerSeat = 2; // Maximum students per seat

// Seat occupancy status for each room, seat, and department
int seatOccupied[numRooms][maxSeatsPerRoom][maxStudentsPerSeat] = {0};

struct Student {
    int id;
    std::string department;
    int assignedRoom;
    int assignedSeat;
    std::string name;
};

// Function to split a string based on a delimiter
std::vector<std::string> splitString(const std::string& s, char delimiter) {
    std::vector<std::string> tokens;
    std::string token;
    std::istringstream tokenStream(s);
    while (std::getline(tokenStream, token, delimiter)) {
        tokens.push_back(token);
    }
    return tokens;
}

void assignSeatsAndWriteToCSV(Student& student, std::ofstream& outputFile) {
    #pragma omp critical
    {
        int room = student.assignedRoom;

        for (int seat = 0; seat < maxSeatsPerRoom; ++seat) {
            bool canAssign = true;
            for (int i = 0; i < maxStudentsPerSeat; ++i) {
                if (seatOccupied[room][seat][i] == 1) {
                    canAssign = false;
                    break;
                }
            }

            if (canAssign) {
                for (int i = 0; i < maxStudentsPerSeat; ++i) {
                    seatOccupied[room][seat][i] = 1;
                }
                student.assignedSeat = seat;

                // Write the student information to the CSV file
                outputFile << student.name << "," << student.department << ","
                           << room << "," << seat << "\n";
                break;
            }
        }
    }
}

int main() {
    // Initialize OpenMP
    omp_set_num_threads(numStudents); // Set the number of threads to match the number of students

    // Read student names and department names from "student_detail.csv"
    std::vector<std::string> studentNames;
    std::vector<std::string> departmentNames;
    std::ifstream configfile("subject_config.txt");
    std::string Sub;
    configfile >> Sub;
    configfile.close();

    std::ifstream inputFile("student_detail.csv");
    if (!inputFile.is_open()) {
        std::cerr << "Error: Unable to open student_detail.csv" << std::endl;
        return 1;
    }

    std::string line;
    while (std::getline(inputFile, line)) {
        std::vector<std::string> tokens = splitString(line, ',');
        if (tokens.size() == 2) {
            studentNames.push_back(tokens[0]);
            departmentNames.push_back(tokens[1]);
        }
    }
    inputFile.close();

    if (studentNames.size() != numStudents) {
        std::cerr << "Error: Insufficient data in student_detail.csv" << std::endl;
        return 1;
    }

    Student students[numStudents];

    // Initialize students with names and departments
    #pragma omp parallel for
    for (int i = 0; i < numStudents; ++i) {
        students[i].id = i;
        students[i].name = studentNames[i];
        students[i].department = departmentNames[i];
        students[i].assignedRoom = i % numRooms; // Distribute students across rooms
        students[i].assignedSeat = -1;
    }

    // Open the CSV file for writing and clear it
    std::ofstream outputFile(Sub, std::ofstream::trunc);
    outputFile << "ID,Department,Room,Seat\n";  // Write header

    // Initialize OpenMP parallelism
    #pragma omp parallel
    {
        #pragma omp for
        for (int student = 0; student < numStudents; ++student) {
            assignSeatsAndWriteToCSV(students[student], outputFile);
        }
    }

    // Close the output file
    outputFile.close();

    return 0;
}
