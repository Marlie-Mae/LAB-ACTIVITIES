import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class CustomerDetailsPage extends JFrame {
    private JTextField nameField;
    private JTextField addressField;
    private JTextField contactField;
    private JTextField remarksField;

    public CustomerDetailsPage() {
        initComponents();
    }

    private void initComponents() {
        setTitle("Customer's Details Page");
        setDefaultCloseOperation(WindowConstants.DISPOSE_ON_CLOSE);
        setSize(500, 460);
        //Color brownColor = new Color(216, 174, 126); 
        //getContentPane().setBackground(brownColor);
        getContentPane().setBackground(Color.WHITE);
        setLayout(new GridBagLayout());

        GridBagConstraints constraints = new GridBagConstraints();
        constraints.anchor = GridBagConstraints.WEST;
        constraints.insets = new Insets(5, 5, 5, 5);

        // Title label
        JLabel titleLabel = new JLabel("Customer's Details");
        titleLabel.setHorizontalAlignment(SwingConstants.CENTER);
        titleLabel.setFont(new Font("Arial", Font.BOLD, 23));
        titleLabel.setBorder(BorderFactory.createEmptyBorder(10, 137, 10, 10));
        constraints.gridx = 0;
        constraints.gridy = 0;
        constraints.gridwidth = 2;
        add(titleLabel, constraints);

        JLabel nameLabel = new JLabel("Customer's Name:");
        constraints.gridx = 0;
        constraints.gridy = 1;
        constraints.gridwidth = 1;
        add(nameLabel, constraints);

        nameField = new JTextField(22);
        constraints.gridx = 1;
        constraints.gridy = 2;
        add(nameField, constraints);

        JLabel addressLabel = new JLabel("Address:");
        constraints.gridx = 0;
        constraints.gridy = 3;
        add(addressLabel, constraints);

        addressField = new JTextField(22);
        constraints.gridx = 1;
        constraints.gridy = 4;
        add(addressField, constraints);

        JLabel contactLabel = new JLabel("Contact No.:");
        constraints.gridx = 0;
        constraints.gridy = 5;
        add(contactLabel, constraints);

        contactField = new JTextField(22);
        constraints.gridx = 1;
        constraints.gridy = 6;
        add(contactField, constraints);

        JLabel remarksLabel = new JLabel("Remarks:");
        constraints.gridx = 0;
        constraints.gridy = 7;
        add(remarksLabel, constraints);

        remarksField = new JTextField(22);
        remarksField.setPreferredSize(new Dimension(remarksField.getPreferredSize().width, 80));
        constraints.gridx = 1;
        constraints.gridy = 8;
        add(remarksField, constraints);

        // Adding empty labels for spacing
        JLabel emptyLabel1 = new JLabel();
        constraints.gridx = 0;
        constraints.gridy = 10;
        add(emptyLabel1, constraints);

        JLabel emptyLabel2 = new JLabel();
        constraints.gridx = 1;
        add(emptyLabel2, constraints);

        JButton cancelButton = new JButton("Cancel");
        cancelButton.setPreferredSize(new Dimension(100, 40)); // Set preferred size
        cancelButton.setFont(cancelButton.getFont().deriveFont(Font.BOLD, 15));
        cancelButton.setBackground(new Color(92, 64, 51));
        cancelButton.setForeground(Color.WHITE);
        cancelButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                clearFields();
            }
        });
        constraints.gridx = 0;
        constraints.gridy = 11;
        constraints.gridwidth = 2;
        add(cancelButton, constraints);

        JButton proceedButton = new JButton("Proceed");
        proceedButton.setPreferredSize(new Dimension(100, 40)); // Set preferred size
        proceedButton.setFont(proceedButton.getFont().deriveFont(Font.BOLD, 15));
        proceedButton.setBackground(new Color(92, 64, 51));
        proceedButton.setForeground(Color.WHITE);
        proceedButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                // Redirect to the OrderPage
                dispose(); // Close the current window
                OrderPage orderPage = new OrderPage(
                        nameField.getText(),
                        addressField.getText(),
                        contactField.getText(),
                        remarksField.getText()
                );
                orderPage.setVisible(true);
            }
        });
        constraints.gridx = 2;
        constraints.gridy = 11;
        constraints.gridwidth = 2;
        add(proceedButton, constraints);
    }

    private void clearFields() {
        nameField.setText("");
        addressField.setText("");
        contactField.setText("");
        remarksField.setText("");
    }

    public String getNameInput() {
        return nameField.getText();
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(new Runnable() {
            @Override
            public void run() {
                CustomerDetailsPage customerDetailsPage = new CustomerDetailsPage();
                customerDetailsPage.setVisible(true);
            }
        });
    }
}
